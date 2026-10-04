<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use App\SavedMessage;
use App\ChatEntity;
use App\Chat;
use App\EntityMessage;
use App\EntityMessageView;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Support\UserSettings;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * file_path ustunida GIF kabi TASHQI URL saqlangan bo'lishi mumkin.
     * Agar http(s) bilan boshlansa — o'sha URL'ni to'g'ridan-to'g'ri qaytaramiz,
     * aks holda serverdagi faylning storage URL'ini hisoblaymiz.
     * (PHP 7.4 mos: str_starts_with o'rniga strpos ishlatiladi)
     */
    private function resolveFileUrl($path)
    {
        if (!$path) {
            return null;
        }
        if (strpos($path, 'http://') === 0 || strpos($path, 'https://') === 0) {
            return $path;
        }
        return Storage::disk('public')->url($path);
    }

    /** Prevent all outgoing chat content during the user's configured quiet hours. */
    private function ensureMessagingAllowed(Request $request)
    {
        $settings = UserSettings::for($request->user());
        if (empty($settings['quiet_hours_enabled'])) {
            return;
        }

        $timezone = (string) $request->header('X-Client-Timezone', config('app.timezone', 'UTC'));
        try {
            $zone = new \DateTimeZone($timezone);
        } catch (\Exception $exception) {
            $zone = new \DateTimeZone(config('app.timezone', 'UTC'));
        }

        $now = new \DateTimeImmutable('now', $zone);
        $minuteOfDay = ((int) $now->format('G') * 60) + (int) $now->format('i');
        $start = $this->timeToMinutes($settings['quiet_hours_start'] ?? '06:00');
        $end = $this->timeToMinutes($settings['quiet_hours_end'] ?? '22:00');

        $isOpen = $start === $end || ($start < $end
            ? ($minuteOfDay >= $start && $minuteOfDay < $end)
            : ($minuteOfDay >= $start || $minuteOfDay < $end));

        abort_unless($isOpen, 403, $settings['quiet_hours_message'] ?? 'Messaging is unavailable during quiet hours.');
    }

    private function timeToMinutes($time)
    {
        if (!preg_match('/^(\d{2}):(\d{2})$/', (string) $time, $matches)) {
            return 0;
        }

        return ((int) $matches[1] * 60) + (int) $matches[2];
    }

    /** $user hozir dam olish vaqtidami? [bool, eslatma matni] qaytaradi. */
    private function quietStateFor($user)
    {
        $settings = UserSettings::for($user);
        $message = $settings['quiet_hours_message'] ?? "Bugungi yozishmalar vaqti tugadi. Dam olishingizni so'raymiz 🌙";

        $enabled = array_key_exists('quiet_hours_enabled', $settings)
            ? !empty($settings['quiet_hours_enabled'])
            : true;
        if (!$enabled) {
            return [false, $message];
        }

        $zone = new \DateTimeZone(config('app.timezone', 'UTC'));
        $now = new \DateTimeImmutable('now', $zone);
        $minuteOfDay = ((int) $now->format('G') * 60) + (int) $now->format('i');
        $start = $this->timeToMinutes($settings['quiet_hours_start'] ?? '06:00');
        $end = $this->timeToMinutes($settings['quiet_hours_end'] ?? '22:00');

        $isOpen = $start === $end || ($start < $end
            ? ($minuteOfDay >= $start && $minuteOfDay < $end)
            : ($minuteOfDay >= $start || $minuteOfDay < $end));

        return [!$isOpen, $message];
    }

    private function attachEntitySenderDetails($messages, $viewer = null)
    {
        $senders = User::whereIn('id', $messages->pluck('sender_id')->unique()->values())
            ->get(['id', 'name', 'avatar'])
            ->keyBy('id');

        $messages->each(function ($message) use ($senders, $viewer) {
            $sender = $senders->get($message->sender_id);
            $message->sender_name = $sender
                ? (($viewer && !$this->visibleTo($sender, $viewer, 'profile_visibility')) ? 'Foydalanuvchi' : $sender->name)
                : null;
            $avatar = $sender && $sender->avatar && (!$viewer || $this->visibleTo($sender, $viewer, 'profile_photo_visibility'))
                ? $sender->avatar
                : null;
            $message->sender_avatar = $avatar
                ? (strpos($avatar, 'http://') === 0 || strpos($avatar, 'https://') === 0
                    ? $avatar
                    : Storage::disk('public')->url($avatar))
                : null;
        });

        return $messages;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $this->touchPresence(request());
        return view('home');
    }

    public function heartbeat(Request $request)
    {
        $this->touchPresence($request);
        return response()->json(['online' => true]);
    }

    public function notificationFeed(Request $request)
    {
        $request->validate(['after' => ['required', 'numeric', 'min:0']]);
        $user = $request->user();
        $after = date('Y-m-d H:i:s', (int) floor(((float) $request->input('after')) / 1000));
        $events = [];

        $incoming = Message::where('receiver_id', $user->id)
            ->where('created_at', '>=', $after)
            ->where('sender_id', '<>', $user->id)
            ->where('deleted_by_receiver', false)
            ->orderBy('created_at')
            ->orderBy('id')
            ->limit(100)
            ->get();

        $senders = User::whereIn('id', $incoming->pluck('sender_id')->unique()->values())
            ->get(['id', 'name', 'avatar'])
            ->keyBy('id');

        foreach ($incoming as $message) {
            $sender = $senders->get($message->sender_id);
            if (!$sender) continue;
            $message->audio_url = $message->audio_path ? Storage::disk('public')->url($message->audio_path) : null;
            $message->file_url = $this->resolveFileUrl($message->file_path);
            $senderName = $this->visibleTo($sender, $user, 'profile_visibility') ? $sender->name : 'Foydalanuvchi';
            $avatarPath = $this->visibleTo($sender, $user, 'profile_photo_visibility') ? $sender->avatar : null;
            $avatar = $avatarPath
                ? (strpos($avatarPath, 'http://') === 0 || strpos($avatarPath, 'https://') === 0
                    ? $avatarPath
                    : Storage::disk('public')->url($avatarPath))
                : null;
            $events[] = [
                'type' => 'personal',
                'user' => ['id' => $sender->id, 'name' => $senderName, 'avatar' => $avatarPath],
                'message' => $message,
                'sender_name' => $senderName,
                'sender_avatar' => $avatar,
            ];
        }

        $entities = ChatEntity::where('user_id', $user->id)
            ->where('in_home', true)
            ->get(['id', 'type', 'name', 'username', 'avatar', 'members_count', 'created_at', 'chat_name', 'chat_username', 'chat_avatar', 'chat_description', 'chat_created_at'])
            ->keyBy('id');

        if ($entities->isNotEmpty()) {
            $entityMessages = EntityMessage::whereIn('chat_entity_id', $entities->keys())
                ->where('created_at', '>=', $after)
                ->where('sender_id', '<>', $user->id)
                ->orderBy('created_at')
                ->orderBy('id')
                ->limit(100)
                ->get();
            $this->attachEntitySenderDetails($entityMessages, $user);

            foreach ($entityMessages as $message) {
                $entity = $entities->get($message->chat_entity_id);
                if (!$entity) continue;
                $isDiscussion = !is_null($message->chat_id);
                $message->is_channel_post = !$isDiscussion;
                $message->audio_url = $message->audio_path ? Storage::disk('public')->url($message->audio_path) : null;
                $message->file_url = $this->resolveFileUrl($message->file_path);
                $events[] = [
                    'type' => $isDiscussion ? 'chat' : $entity->type,
                    'entity' => [
                        'id' => $entity->id,
                        'type' => $isDiscussion ? 'chat' : $entity->type,
                        'name' => $isDiscussion ? ($entity->chat_name ?: $entity->name) : $entity->name,
                        'username' => $isDiscussion ? $entity->chat_username : $entity->username,
                        'avatar' => $isDiscussion ? $entity->chat_avatar : $entity->avatar,
                        'members_count' => $entity->members_count,
                        'created_at' => $isDiscussion ? ($entity->chat_created_at ?: $entity->created_at) : $entity->created_at,
                    ],
                    'message' => $message,
                    'sender_name' => $message->sender_name ?: $entity->name,
                    'sender_avatar' => $message->sender_avatar,
                ];
            }
        }

        usort($events, function ($left, $right) {
            return strcmp((string) $left['message']->created_at, (string) $right['message']->created_at)
                ?: ((int) $left['message']->id <=> (int) $right['message']->id);
        });

        return response()->json(['events' => $events]);
    }

    public function entityMessages(Request $request, ChatEntity $entity)
    {
        abort_if($entity->user_id !== $request->user()->id || !$entity->in_home, 404);
        $messages = EntityMessage::where('chat_entity_id', $entity->id)->whereNull('chat_id')->withCount('views')->oldest()->get();
        $this->attachEntitySenderDetails($messages);
        $messages->each(function ($message) {
            $message->audio_url = $message->audio_path ? Storage::disk('public')->url($message->audio_path) : null;
            $message->file_url = $this->resolveFileUrl($message->file_path);
            $message->sender_id = (int) $message->sender_id;
        });
        return response()->json(['messages' => $messages, 'entity' => $entity]);
    }

    /**
     * Profilga bog'langan (profile_linked) kanalning postlarini ko'rsatish uchun.
     * Bu — boshqa foydalanuvchi profilida ko'rinadigan ommaviy kanal, shuning
     * uchun egalik tekshiruvi (user_id === viewer) talab qilinmaydi.
     */
    public function publicChannelMessages(Request $request, ChatEntity $entity)
    {
        abort_if($entity->type !== 'channel' || !$entity->profile_linked, 404);

        $messages = EntityMessage::where('chat_entity_id', $entity->id)
            ->whereNull('chat_id')
            ->withCount('views')
            ->latest()
            ->limit(1)
            ->get();

        $this->attachEntitySenderDetails($messages);
        $messages->each(function ($message) {
            $message->audio_url = $message->audio_path ? Storage::disk('public')->url($message->audio_path) : null;
            $message->file_url = $this->resolveFileUrl($message->file_path);
            $message->sender_id = (int) $message->sender_id;
        });

        return response()->json(['messages' => $messages, 'entity' => $entity]);
    }

    public function markViewedEntityMessage(Request $request, EntityMessage $message)
    {
        $message->views()->firstOrCreate(['user_id' => $request->user()->id]);
        return response()->json(['views_count' => $message->views()->count()]);
    }

    /**
     * Kanalga (yoki guruhga) xabar/post yuboradi.
     *
     * MUHIM: agar bu kanalga "muhokama chati" biriktirilgan bo'lsa (Chat modeli
     * orqali), postning bir nusxasi avtomatik ravishda o'sha chatga ham
     * ko'chiriladi (chat_id o'rnatilgan holda) — xuddi Telegram'dagi
     * "kanal posti -> biriktirilgan guruhga forward" mexanizmi kabi.
     * Frontend discussion-chat'ni ochganda barcha chat_id'li xabarlarni
     * "forceIn" (chapdan) sifatida ko'rsatadi, shuning uchun bu yerda
     * qo'shimcha flag berish shart emas.
     */
    public function sendEntityMessage(Request $request, ChatEntity $entity)
    {
        $this->ensureMessagingAllowed($request);
        abort_if($entity->user_id !== $request->user()->id || !$entity->in_home, 404);
        $data = $request->validate([
            'body' => ['nullable', 'string', 'max:10000'],
            'audio' => ['nullable', 'file', 'mimes:webm,ogg,wav,mp3,m4a', 'max:51200'],
            'file' => ['nullable', 'file', 'max:51200'],
            'gif_url' => ['nullable', 'url', 'max:2000'],
            'duration' => ['nullable', 'integer', 'min:0', 'max:3600'],
        ]);
        $audio = $request->file('audio');
        $file = $request->file('file');
        $gifUrl = isset($data['gif_url']) ? $data['gif_url'] : null;

        $audioPath = $audio ? $audio->store('entity-messages', 'public') : null;
        $filePath = $gifUrl ? $gifUrl : ($file ? $file->store('entity-message-files', 'public') : null);
        $fileName = $gifUrl ? 'gif.gif' : ($file ? $file->getClientOriginalName() : null);
        $fileMime = $gifUrl ? 'image/gif' : ($file ? $file->getClientMimeType() : null);
        $fileSize = $gifUrl ? null : ($file ? $file->getSize() : null);

        $message = EntityMessage::create([
            'chat_entity_id' => $entity->id,
            'sender_id' => $request->user()->id,
            'body' => $data['body'] ?? '',
            'audio_path' => $audioPath,
            'audio_duration' => $data['duration'] ?? null,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_mime' => $fileMime,
            'file_size' => $fileSize,
        ]);

        $message->audio_url = $audioPath ? Storage::disk('public')->url($audioPath) : null;
        $message->file_url = $this->resolveFileUrl($filePath);
        $message->views_count = 0;
        return response()->json(['message' => $message], 201);
    }

    /**
     * Kanalga biriktirilgan "muhokama chati"dagi xabarlarni olib keladi.
     * Bular EntityMessage jadvalida chat_id ustuni orqali ajratiladi,
     * kanalning o'z postlaridan mustaqil.
     */
    public function chatMessages(Request $request, ChatEntity $entity)
    {
        abort_if($entity->user_id !== $request->user()->id || !$entity->in_home || $entity->type !== 'channel', 404);
        $chat = Chat::where('chat_entity_id', $entity->id)->firstOrFail();

        $messages = EntityMessage::where('chat_entity_id', $entity->id)
            ->where(function ($q) use ($chat) {
                // 1) kanalning asl postlari (chat_id yo'q)
                $q->whereNull('chat_id')
                  // 2) shu chatdagi oddiy xabarlar (eski nusxalar chiqmasin)
                  ->orWhere(function ($qq) use ($chat) {
                      $qq->where('chat_id', $chat->id)
                         ->where(function ($x) {
                             $x->where('is_channel_post', false)->orWhereNull('is_channel_post');
                         });
                  });
            })
            ->withCount('views')
            ->orderBy('created_at')
            ->orderBy('id')
            ->get();

        $this->attachEntitySenderDetails($messages);
        $messages->each(function ($message) {
            // post yoki chat xabarimi: chat_id dan aniqlaymiz
            $message->is_channel_post = is_null($message->chat_id);
            $message->audio_url = $message->audio_path ? Storage::disk('public')->url($message->audio_path) : null;
            $message->file_url = $this->resolveFileUrl($message->file_path);
            $message->sender_id = (int) $message->sender_id;
        });

        return response()->json(['messages' => $messages, 'chat' => $chat]);
    }

    /**
     * Kanalga biriktirilgan "muhokama chati"ga xabar yuboradi.
     * chat_entity_id — kanalning o'zi (egalik tekshiruvi uchun),
     * chat_id — aynan shu chat yozuvi (xabarni kanal postidan ajratish uchun).
     */
    public function sendChatMessage(Request $request, ChatEntity $entity)
    {
        $this->ensureMessagingAllowed($request);
        abort_if($entity->user_id !== $request->user()->id || !$entity->in_home || $entity->type !== 'channel', 404);
        $chat = Chat::where('chat_entity_id', $entity->id)->firstOrFail();
        $data = $request->validate([
            'body' => ['nullable', 'string', 'max:10000'],
            'audio' => ['nullable', 'file', 'mimes:webm,ogg,wav,mp3,m4a', 'max:51200'],
            'file' => ['nullable', 'file', 'max:51200'],
            'gif_url' => ['nullable', 'url', 'max:2000'],
            'duration' => ['nullable', 'integer', 'min:0', 'max:3600'],
        ]);
        $audio = $request->file('audio');
        $file = $request->file('file');
        $gifUrl = isset($data['gif_url']) ? $data['gif_url'] : null;

        $audioPath = $audio ? $audio->store('entity-messages', 'public') : null;
        $filePath = $gifUrl ? $gifUrl : ($file ? $file->store('entity-message-files', 'public') : null);
        $fileName = $gifUrl ? 'gif.gif' : ($file ? $file->getClientOriginalName() : null);
        $fileMime = $gifUrl ? 'image/gif' : ($file ? $file->getClientMimeType() : null);
        $fileSize = $gifUrl ? null : ($file ? $file->getSize() : null);

        $message = EntityMessage::create([
            'chat_entity_id' => $entity->id,
            'chat_id' => $chat->id,
            'sender_id' => $request->user()->id,
            'body' => $data['body'] ?? '',
            'audio_path' => $audioPath,
            'audio_duration' => $data['duration'] ?? null,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_mime' => $fileMime,
            'file_size' => $fileSize,
        ]);
        $message->audio_url = $message->audio_path ? Storage::disk('public')->url($message->audio_path) : null;
        $message->file_url = $this->resolveFileUrl($message->file_path);
        $message->views_count = 0;
        $message->is_channel_post = false;
        return response()->json(['message' => $message], 201);
    }

    public function chatList(Request $request)
    {
        $userId = $request->user()->id;
        $messages = Message::query()
            ->where(function ($q) use ($userId) {
                $q->where(function ($qq) use ($userId) {
                    $qq->where('sender_id', $userId)->where('deleted_by_sender', false);
                })->orWhere(function ($qq) use ($userId) {
                    $qq->where('receiver_id', $userId)->where('deleted_by_receiver', false);
                });
            })
            ->latest('created_at')
            ->get(['sender_id', 'receiver_id', 'body', 'audio_path', 'audio_duration', 'file_path', 'file_name', 'file_mime', 'file_size', 'read_at', 'created_at']);

        $conversationIds = [];
        $latestMessages = [];
        $unreadCounts = [];
        foreach ($messages as $message) {
            $otherId = (int) ($message->sender_id === $userId ? $message->receiver_id : $message->sender_id);
            $conversationIds[$otherId] = $otherId;
            if (!isset($latestMessages[$otherId])) {
                $message->audio_url = $message->audio_path ? Storage::disk('public')->url($message->audio_path) : null;
                $message->file_url = $this->resolveFileUrl($message->file_path);
                $latestMessages[$otherId] = $message;
            }
            if ((int) $message->receiver_id === $userId && !$message->read_at) {
                $unreadCounts[$otherId] = ($unreadCounts[$otherId] ?? 0) + 1;
            }
        }

        $users = User::query()
            ->whereIn('id', array_values($conversationIds))
            ->get(['id', 'name', 'surname', 'username', 'email', 'avatar', 'last_seen_at'])
            ->keyBy('id');

        $chats = [];
        foreach ($latestMessages as $otherId => $message) {
            $user = $users->get($otherId);
            if (!$user) continue;
            $chats[] = [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'surname' => $user->surname,
                    'username' => $user->username,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'online' => (bool) ($user->last_seen_at && $user->last_seen_at->gt(now()->subMinutes(2))),
                ],
                'message' => $message,
                'unread_count' => $unreadCounts[$otherId] ?? 0,
            ];
        }

        $entities = ChatEntity::query()
            ->where('user_id', $userId)
            ->where('in_home', true)
            ->latest('updated_at')
            ->get(['id', 'type', 'name', 'username', 'avatar', 'description', 'members_count', 'created_at', 'updated_at', 'chat_name', 'chat_username', 'chat_avatar', 'chat_description', 'chat_created_at'])
            ->map(function ($entity) {
                return [
                    'id' => $entity->id,
                    'type' => $entity->type,
                    'name' => $entity->name,
                    'username' => $entity->username,
                    'avatar' => $entity->avatar,
                    'description' => $entity->description,
                    'members_count' => $entity->members_count,
                    'created_at' => $entity->created_at,
                    'updated_at' => $entity->updated_at,
                    'chat_name' => $entity->chat_name,
                    'chat_username' => $entity->chat_username,
                    'chat_avatar' => $entity->chat_avatar,
                    'chat_description' => $entity->chat_description,
                    'chat_created_at' => $entity->chat_created_at,
                ];
            })->values();

        return response()->json(['chats' => $chats, 'entities' => $entities]);
    }

    public function searchUsers(Request $request)
    {
        $query = ltrim(trim((string) $request->query('q', '')), '@');

        if ($query === '') {
            return response()->json(['users' => []]);
        }

        $users = User::query()
            ->where('id', '!=', $request->user()->id)
            ->where(function ($builder) use ($query) {
                $like = '%' . $query . '%';

                $builder->where('name', 'like', $like)
                    ->orWhere('surname', 'like', $like)
                    ->orWhere('username', 'like', $like)
                    ->orWhere('email', 'like', $like);
            })
            ->select(['id', 'name', 'surname', 'username', 'email', 'avatar', 'last_seen_at'])
            ->orderBy('name')
            ->limit(30)
            ->get()
            ->map(function ($user) {
                $user->online = (bool) ($user->last_seen_at && $user->last_seen_at->gt(now()->subMinutes(2)));
                return $user;
            });

        return response()->json(['users' => $users]);
    }

    public function messages(Request $request, User $user)
    {
        abort_if($user->id === $request->user()->id, 404);
        $viewerId = $request->user()->id;

        if (!$request->boolean('preview')) {
            Message::query()
                ->where('sender_id', $user->id)
                ->where('receiver_id', $viewerId)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        $messages = Message::query()
            ->where(function ($builder) use ($viewerId, $user) {
                $builder->where(function ($q) use ($viewerId, $user) {
                    $q->where('sender_id', $viewerId)
                        ->where('receiver_id', $user->id);
                })->orWhere(function ($q) use ($viewerId, $user) {
                    $q->where('sender_id', $user->id)
                        ->where('receiver_id', $viewerId);
                });
            })
            ->where(function ($builder) use ($viewerId) {
                // Shu foydalanuvchi tomonidan "faqat men uchun" o'chirilgan xabarlarni chiqarmaymiz
                $builder->where(function ($q) use ($viewerId) {
                    $q->where('sender_id', $viewerId)->where('deleted_by_sender', false);
                })->orWhere(function ($q) use ($viewerId) {
                    $q->where('receiver_id', $viewerId)->where('deleted_by_receiver', false);
                });
            })
            ->oldest()
            ->get(['id', 'sender_id', 'receiver_id', 'body', 'audio_path', 'audio_duration', 'file_path', 'file_name', 'file_mime', 'file_size', 'read_at', 'created_at'])
            ->map(function ($message) {
                $message->audio_url = $message->audio_path ? Storage::disk('public')->url($message->audio_path) : null;
                $message->file_url = $this->resolveFileUrl($message->file_path);
                return $message;
            });

        $channelData = null;
        $firstChannel = $user->chatEntities()->where('profile_linked', true)->latest()->first();
        if ($firstChannel) {
            $channelData = [
                'id' => $firstChannel->id,
                'name' => $firstChannel->name,
                'username' => $firstChannel->username,
                'avatar' => $firstChannel->avatar,
                'type' => $firstChannel->type,
                'members_count' => $firstChannel->members_count,
                'updated_at' => $firstChannel->updated_at,
            ];
        }

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'surname' => $user->surname,
                'username' => $user->username,
                'avatar' => $this->visibleTo($user, $request->user(), 'profile_photo_visibility') ? $user->avatar : null,
                'phone' => $user->show_phone ? $user->phone : null,
                'email' => $user->show_email ? $user->email : null,
                'bio' => $this->visibleTo($user, $request->user(), 'bio_visibility') ? $user->bio : null,
                'channel' => $channelData,
                'bubble_color' => $user->bubble_color,
                'quiet_now' => $this->quietStateFor($user)[0],
                'quiet_message' => $this->quietStateFor($user)[1],
                'online' => $this->visibleTo($user, $request->user(), 'online_visibility')
                    && $user->last_seen_at && $user->last_seen_at->gt(now()->subMinutes(2)),
                'last_seen_at' => $this->visibleTo($user, $request->user(), 'last_seen_visibility') ? $user->last_seen_at : null,
                'stories_count' => Story::where('user_id', $user->id)
                    ->count(),
            ],
            'messages' => $messages,
            'unread_count' => Message::query()
                ->where('sender_id', $user->id)
                ->where('receiver_id', $viewerId)
                ->whereNull('read_at')
                ->count(),
        ]);
    }

    public function sendMessage(Request $request, User $user)
    {
        $this->ensureMessagingAllowed($request);
        abort_if($user->id === $request->user()->id, 404);

        list($peerQuiet, $peerQuietMessage) = $this->quietStateFor($user);
        if ($peerQuiet) {
            return response()->json(['message' => $peerQuietMessage], 423);
        }

        $data = $request->validate([
            'body' => ['nullable', 'string', 'max:10000'],
            'audio' => ['nullable', 'file', 'mimes:webm,ogg,wav,mp3,m4a', 'max:51200'],
            'file' => ['nullable', 'file', 'max:51200'],
            'gif_url' => ['nullable', 'url', 'max:2000'],
            'duration' => ['nullable', 'integer', 'min:0', 'max:3600'],
        ]);

        if (!$this->visibleTo($user, $request->user(), 'who_can_message')) {
            return response()->json(['message' => "Bu foydalanuvchi sizdan xabar qabul qilmaydi."], 403);
        }

        $audioPath = $request->hasFile('audio') ? $request->file('audio')->store('messages', 'public') : null;
        $file = $request->file('file');
        $gifUrl = isset($data['gif_url']) ? $data['gif_url'] : null;

        $filePath = $gifUrl ? $gifUrl : ($file ? $file->store('message-files', 'public') : null);
        $fileName = $gifUrl ? 'gif.gif' : ($file ? $file->getClientOriginalName() : null);
        $fileMime = $gifUrl ? 'image/gif' : ($file ? $file->getClientMimeType() : null);
        $fileSize = $gifUrl ? null : ($file ? $file->getSize() : null);

        $message = Message::create([
            'sender_id' => $request->user()->id,
            'receiver_id' => $user->id,
            'body' => $data['body'] ?? '',
            'audio_path' => $audioPath,
            'audio_duration' => $data['duration'] ?? null,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_mime' => $fileMime,
            'file_size' => $fileSize,
        ]);

        $message = $message->fresh();
        $message->audio_url = $audioPath ? Storage::disk('public')->url($audioPath) : null;
        $message->file_url = $this->resolveFileUrl($filePath);
        return response()->json(['message' => $message], 201);
    }

    public function deleteMessage(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $userId = $request->user()->id;

        // Faqat suhbat ishtirokchisi (jo'natuvchi yoki qabul qiluvchi) o'chira oladi
        abort_if($message->sender_id !== $userId && $message->receiver_id !== $userId, 403);

        $forEveryone = $request->boolean('for_everyone');

        if ($forEveryone) {
            // "Hammaga o'chirish" faqat xabar egasiga (jo'natuvchiga) ruxsat etiladi
            abort_if($message->sender_id !== $userId, 403);
            $message->delete();

            return response()->json(['success' => true, 'for_everyone' => true]);
        }

        // Faqat o'zim uchun o'chirish — boshqa tomonda xabar qolishi kerak
        if ($message->sender_id === $userId) {
            $message->deleted_by_sender = true;
        } else {
            $message->deleted_by_receiver = true;
        }
        $message->save();

        // Ikkala tomon ham o'chirgan bo'lsa, qatorni bazadan butunlay tozalaymiz
        if ($message->deleted_by_sender && $message->deleted_by_receiver) {
            $message->delete();
        }

        return response()->json(['success' => true, 'for_everyone' => false]);
    }

    // ====================================================================
    // YANGI: tarixni tozalash va kanal/guruhdan chiqish
    // ====================================================================

    /** Fayllarni (tashqi URL bo'lmasa) storage'dan o'chiradi. */
    private function deleteStoredFiles(array $paths)
    {
        foreach ($paths as $path) {
            if ($path && strpos($path, 'http://') !== 0 && strpos($path, 'https://') !== 0) {
                Storage::disk('public')->delete($path);
            }
        }
    }

    /** EntityMessage so'rovidagi barcha xabarlarni (fayl va ko'rishlari bilan) o'chiradi. */
    private function purgeEntityMessages($query)
    {
        $count = 0;
        $query->get()->each(function ($message) use (&$count) {
            $this->deleteStoredFiles([$message->audio_path, $message->file_path]);
            $message->views()->delete();
            $message->delete();
            $count++;
        });
        return $count;
    }

    /** Lichka suhbat tarixini tozalash. for_everyone=1 bo'lsa ikkala tomondan o'chadi. */
    public function clearMessages(Request $request, User $user)
    {
        abort_if($user->id === $request->user()->id, 404);
        $me = $request->user()->id;

        $conversation = function () use ($me, $user) {
            return Message::where(function ($q) use ($me, $user) {
                $q->where(function ($qq) use ($me, $user) {
                    $qq->where('sender_id', $me)->where('receiver_id', $user->id);
                })->orWhere(function ($qq) use ($me, $user) {
                    $qq->where('sender_id', $user->id)->where('receiver_id', $me);
                });
            });
        };

        if ($request->boolean('for_everyone')) {
            $messages = $conversation()->get();
            foreach ($messages as $m) {
                $this->deleteStoredFiles([$m->audio_path, $m->file_path]);
                $m->delete();
            }
            return response()->json(['success' => true, 'for_everyone' => true, 'cleared' => $messages->count()]);
        }

        // Faqat men uchun: o'zim tomonimdagi flaglarni qo'yamiz
        $conversation()->where('sender_id', $me)->update(['deleted_by_sender' => true]);
        $conversation()->where('receiver_id', $me)->update(['deleted_by_receiver' => true]);

        // Ikkala tomon ham o'chirgan qatorlarni butunlay tozalaymiz
        $orphans = $conversation()->where('deleted_by_sender', true)->where('deleted_by_receiver', true)->get();
        foreach ($orphans as $m) {
            $this->deleteStoredFiles([$m->audio_path, $m->file_path]);
            $m->delete();
        }

        return response()->json(['success' => true, 'for_everyone' => false]);
    }

    /** Kanal postlari tarixini tozalash (faqat egasi). */
    public function clearEntityMessages(Request $request, ChatEntity $entity)
    {
        abort_if($entity->user_id !== $request->user()->id || !$entity->in_home, 404);

        $cleared = $this->purgeEntityMessages(
            EntityMessage::where('chat_entity_id', $entity->id)->whereNull('chat_id')
        );

        return response()->json(['success' => true, 'cleared' => $cleared]);
    }

    /** Kanalga biriktirilgan muhokama chati tarixini tozalash (faqat egasi). */
    public function clearEntityChat(Request $request, ChatEntity $entity)
    {
        abort_if($entity->user_id !== $request->user()->id || !$entity->in_home || $entity->type !== 'channel', 404);
        $chat = Chat::where('chat_entity_id', $entity->id)->firstOrFail();

        $cleared = $this->purgeEntityMessages(
            EntityMessage::where('chat_entity_id', $entity->id)->where('chat_id', $chat->id)
        );

        return response()->json(['success' => true, 'cleared' => $cleared]);
    }

    /** Kanal/guruhdan chiqish: bosh ro'yxatdan olib tashlaydi (ma'lumot saqlanib qoladi). */
    public function leaveEntity(Request $request, ChatEntity $entity)
    {
        abort_if($entity->user_id !== $request->user()->id, 404);
        $entity->update(['in_home' => false, 'profile_linked' => false]);

        return response()->json(['success' => true, 'left' => true]);
    }

    // ====================================================================

    public function savedMessages(Request $request)
    {
        return response()->json([
            'messages' => SavedMessage::query()
                ->where('user_id', $request->user()->id)
                ->oldest()
                ->get(['id', 'user_id', 'body', 'audio_path', 'audio_duration', 'file_path', 'file_name', 'file_mime', 'file_size', 'created_at'])
                ->map(function ($message) use ($request) {
                    $message->sender_id = $request->user()->id;
                    $message->receiver_id = $request->user()->id;
                    $message->read_at = $message->created_at;
                    $message->audio_url = $message->audio_path ? Storage::disk('public')->url($message->audio_path) : null;
                    $message->file_url = $this->resolveFileUrl($message->file_path);
                    return $message;
                }),
        ]);
    }

    public function saveMessage(Request $request)
    {
        $data = $request->validate([
            'body' => ['nullable', 'string', 'max:10000'],
            'audio' => ['nullable', 'file', 'mimes:webm,ogg,wav,mp3,m4a', 'max:51200'],
            'file' => ['nullable', 'file', 'max:51200'],
            'gif_url' => ['nullable', 'url', 'max:2000'],
            'duration' => ['nullable', 'integer', 'min:0', 'max:3600'],
        ]);
        $audioPath = $request->hasFile('audio') ? $request->file('audio')->store('saved-messages', 'public') : null;
        $file = $request->file('file');
        $gifUrl = isset($data['gif_url']) ? $data['gif_url'] : null;

        $filePath = $gifUrl ? $gifUrl : ($file ? $file->store('saved-message-files', 'public') : null);
        $fileName = $gifUrl ? 'gif.gif' : ($file ? $file->getClientOriginalName() : null);
        $fileMime = $gifUrl ? 'image/gif' : ($file ? $file->getClientMimeType() : null);
        $fileSize = $gifUrl ? null : ($file ? $file->getSize() : null);

        $message = SavedMessage::create([
            'user_id' => $request->user()->id,
            'body' => $data['body'] ?? '',
            'audio_path' => $audioPath,
            'audio_duration' => $data['duration'] ?? null,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_mime' => $fileMime,
            'file_size' => $fileSize,
        ]);
        $message->sender_id = $request->user()->id;
        $message->receiver_id = $request->user()->id;
        $message->read_at = $message->created_at;
        $message->audio_url = $audioPath ? Storage::disk('public')->url($audioPath) : null;
        $message->file_url = $this->resolveFileUrl($filePath);

        return response()->json(['message' => $message], 201);
    }

    public function deleteSavedMessage(Request $request, $id)
    {
        $message = SavedMessage::where('user_id', $request->user()->id)->findOrFail($id);
        $message->delete();

        return response()->json(['success' => true]);
    }

    public function userStories(Request $request, User $user)
    {
        $viewerId = $request->user()->id;
        $isOwner = $user->id === $viewerId;

        $stories = Story::where('user_id', $user->id)
            ->oldest()
            ->get();

        $stories = $stories->map(function ($story) use ($viewerId, $isOwner) {
            return [
                'id' => $story->id,
                'media_url' => $this->resolveFileUrl($story->media_path),
                'type' => $story->type,
                'caption' => $story->caption,
                'created_at' => $story->created_at,
                'viewed' => $story->views()->where('user_id', $viewerId)->exists(),
                'views_count' => $isOwner ? $story->views()->count() : null,
            ];
        })->values();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'avatar' => $user->avatar,
            ],
            'stories' => $stories,
        ]);
    }

    private function areContacts($a, $b)
    {
        return Message::where(function ($q) use ($a, $b) {
            $q->where('sender_id', $a->id)->where('receiver_id', $b->id);
        })->orWhere(function ($q) use ($a, $b) {
            $q->where('sender_id', $b->id)->where('receiver_id', $a->id);
        })->exists();
    }

    /** $owner ma'lumotini $viewer ko'ra oladimi? */
    private function visibleTo($owner, $viewer, $key)
    {
        $value = UserSettings::for($owner)[$key] ?? 'everyone';
        if ($value === 'everyone') return true;
        if ($value === 'nobody') return false;
        return $this->areContacts($owner, $viewer);
    }

    private function touchPresence(Request $request)
    {
        $request->user()->forceFill(['last_seen_at' => now()])->save();
    }
}
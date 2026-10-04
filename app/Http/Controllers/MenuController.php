<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\ChatEntity;
use App\Chat;
use App\Support\UserSettings;
use App\Message;
use App\SavedMessage;
use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile()
    {
        return view('profile.edit', [
            'stories' => $this->currentUserStories(),
            'linkedChannels' => auth()->user()->chatEntities()->where('profile_linked', true)->latest()->get(),
        ]);
    }

    public function searchProfileEntities(Request $request)
    {
        $query = trim((string) $request->query('q', ''));
        $query = preg_replace('#^https?://#i', '', $query);
        $query = preg_replace('#^t\.me/#i', '', $query);
        $query = ltrim($query, '@');
        $entities = auth()->user()->chatEntities()
            ->where(function ($builder) use ($query) {
                $like = '%' . $query . '%';
                $builder->where('name', 'like', $like)
                    ->orWhere('username', 'like', $like)
                    ->orWhere('chat_name', 'like', $like)
                    ->orWhere('chat_username', 'like', $like);
            })
            ->latest()
            ->limit(20)
            ->get();

        return response()->json(['entities' => $entities]);
    }

    public function linkProfileEntity(Request $request)
    {
        $data = $request->validate(['entity_id' => ['required', 'integer']]);
        $entity = auth()->user()->chatEntities()->findOrFail($data['entity_id']);
        $entity->update(['in_home' => true, 'profile_linked' => true]);

        return response()->json(['entity' => $entity->fresh()]);
    }

    public function unlinkProfileEntity(ChatEntity $entity)
    {
        abort_unless($entity->user_id === auth()->id(), 404);
        $entity->update(['profile_linked' => false]);

        return response()->json(['unlinked' => true]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:50', 'alpha_dash', Rule::unique('users')->ignore($user->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'bio' => ['nullable', 'string', 'max:120'],
            'avatar' => [
                'nullable',
                'file',
                'max:10240',
                function ($attribute, $file, $fail) {
                    $allowedExtensions = [
                        'jpg', 'jpeg', 'jfif', 'png', 'gif', 'webp', 'avif',
                        'bmp', 'heic', 'heif', 'tif', 'tiff',
                    ];

                    if (!in_array(strtolower($file->getClientOriginalExtension()), $allowedExtensions, true)) {
                        $fail('JPG, PNG, GIF, WEBP, AVIF, BMP, HEIC yoki TIFF rasm tanlang.');
                    }
                },
            ],
        ]);

        if ($request->boolean('avatar_remove') && $user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $data['avatar'] = null;
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $data['show_phone'] = $request->boolean('show_phone');
        $data['show_email'] = $request->boolean('show_email');

        $user->update($data);

        return redirect()->route('profile.edit')->with('status', 'Profil muvaffaqiyatli saqlandi.');
    }

    public function wallet()
    {
        return $this->page('Hamyon', 'wallet');
    }

    public function group()
    {
        return view('menu.group', ['entities' => $this->getChatEntities('group')]);
    }

    public function channel()
    {
        return view('menu.channel', ['entities' => $this->getChatEntities('channel')]);
    }

    public function chatEntities(Request $request, $type)
    {
        abort_unless(in_array($type, ['channel', 'group'], true), 404);

        return response()->json([
            'entities' => $request->user()->chatEntities()->where('type', $type)->with('chat')->latest()->get(),
        ]);
    }

    public function storeChatEntity(Request $request, $type)
    {
        abort_unless(in_array($type, ['channel', 'group'], true), 404);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:64'],
            'username' => ['nullable', 'string', 'max:32', 'alpha_dash'],
            'description' => ['nullable', 'string', 'max:255'],
            'visibility' => ['required', Rule::in(['public', 'private'])],
            'avatar' => ['nullable', 'string', 'max:5000000'],
            'members_count' => ['nullable', 'integer', 'min:1'],
            'chat_name' => ['nullable', 'string', 'max:64'],
            'chat_username' => ['nullable', 'string', 'max:32', 'alpha_dash'],
            'chat_avatar' => ['nullable', 'string', 'max:20000000'],
            'chat_description' => ['nullable', 'string', 'max:255'],
            'chat_created_at' => ['nullable', 'date'],
        ]);

        $data['type'] = $type;
        $data['user_id'] = $request->user()->id;
        $data['username'] = $data['username'] ?: null;
        $data['members_count'] = $data['members_count'] ?? 1;
        $data['in_home'] = true;

        $entity = ChatEntity::create($data);

        // Kanal uchun chat_name berilgan bo'lsa — unga mos "Chat" yozuvini
        // ham darhol yaratamiz, aks holda /entity-chats/{id} 404 qaytaradi
        // (chunki HomeController@sendChatMessage / chatMessages metodlari
        // Chat::where('chat_entity_id', ...)->firstOrFail() qiladi).
        if ($type === 'channel' && !empty($data['chat_name'])) {
            $chatCreatedAt = $data['chat_created_at'] ?? now();

            $chat = Chat::updateOrCreate(
                ['chat_entity_id' => $entity->id],
                [
                    'name' => $data['chat_name'],
                    'username' => $data['chat_username'] ?? null,
                    'avatar' => $data['chat_avatar'] ?? null,
                    'description' => $data['chat_description'] ?? null,
                    'chat_created_at' => $chatCreatedAt,
                ]
            );

            $entity->setRelation('chat', $chat);
        }

        return response()->json(['entity' => $entity], 201);
    }

    /**
     * Berilgan type + id bo'yicha entity'ni joriy foydalanuvchiga tegishli
     * ekanligini tekshirib qaytaradi. Topilmasa yoki boshqa userniki bo'lsa 404.
     */
    private function findOwnedEntity(Request $request, $type, $id)
    {
        abort_unless(in_array($type, ['channel', 'group'], true), 404);

        return ChatEntity::where('id', $id)
            ->where('type', $type)
            ->where('user_id', $request->user()->id)
            ->firstOrFail();
    }

    public function updateChatEntity(Request $request, $type, $id)
    {
        $entity = $this->findOwnedEntity($request, $type, $id);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:64'],
            'username' => ['nullable', 'string', 'max:32', 'alpha_dash'],
            'description' => ['nullable', 'string', 'max:255'],
            'visibility' => ['required', Rule::in(['public', 'private'])],
            'avatar' => ['nullable', 'string', 'max:5000000'],
            'members_count' => ['nullable', 'integer', 'min:1'],
            'chat_name' => ['nullable', 'string', 'max:64'],
            'chat_username' => ['nullable', 'string', 'max:32', 'alpha_dash'],
            'chat_avatar' => ['nullable', 'string', 'max:5000000'],
            'chat_description' => ['nullable', 'string', 'max:255'],
            'chat_created_at' => ['nullable', 'date'],
        ]);

        $entity->update($data);

        // Shu yerda ham xuddi shu mantiq: agar kanal tahrirlanganda chat_name
        // qo'shilgan/o'zgargan bo'lsa, Chat yozuvini ham sinxron saqlaymiz.
        if ($entity->type === 'channel' && !empty($data['chat_name'])) {
            $chatCreatedAt = $data['chat_created_at'] ?? optional($entity->chat)->chat_created_at ?? now();

            $chat = Chat::updateOrCreate(
                ['chat_entity_id' => $entity->id],
                [
                    'name' => $data['chat_name'],
                    'username' => $data['chat_username'] ?? null,
                    'avatar' => $data['chat_avatar'] ?? null,
                    'description' => $data['chat_description'] ?? null,
                    'chat_created_at' => $chatCreatedAt,
                ]
            );

            $entity->setRelation('chat', $chat);
        }

        return response()->json(['entity' => $entity->fresh()->load('chat')]);
    }

    /**
     * Kanalga bog'langan "muhokama chati"ni yaratadi yoki yangilaydi.
     * MUHIM: bu endi ChatEntity qatorining o'zini emas, alohida
     * `chats` jadvalidagi mustaqil yozuvni yaratadi/yangilaydi —
     * shunda uning HAQIQIY, o'ziga xos ID'si bo'ladi.
     */
    public function storeChat(Request $request, $type, $id)
    {
        $entity = $this->findOwnedEntity($request, $type, $id);

        abort_unless($entity->type === 'channel', 404);

        $data = $request->validate([
            'chat_name' => ['required', 'string', 'max:64'],
            'chat_username' => ['nullable', 'string', 'max:32', 'alpha_dash'],
            'chat_avatar' => ['nullable', 'string', 'max:20000000'],
            'chat_description' => ['nullable', 'string', 'max:255'],
            'chat_created_at' => ['nullable', 'date'],
        ]);

        $chatCreatedAt = $data['chat_created_at'] ?? now();

        // Eski ustunlarni ham to'ldirib boramiz (mavjud kod/blade shularga tayanadi)
        $entity->update([
            'chat_name' => $data['chat_name'],
            'chat_username' => $data['chat_username'] ?? null,
            'chat_avatar' => $data['chat_avatar'] ?? null,
            'chat_description' => $data['chat_description'] ?? null,
            'chat_created_at' => $chatCreatedAt,
        ]);

        // Haqiqiy, mustaqil ID'ga ega Chat yozuvini yaratamiz/yangilaymiz
        $chat = Chat::updateOrCreate(
            ['chat_entity_id' => $entity->id],
            [
                'name' => $data['chat_name'],
                'username' => $data['chat_username'] ?? null,
                'avatar' => $data['chat_avatar'] ?? null,
                'description' => $data['chat_description'] ?? null,
                'chat_created_at' => $chatCreatedAt,
            ]
        );

        $entity = $entity->fresh();
        $entity->setRelation('chat', $chat);

        return response()->json(['entity' => $entity]);
    }

    public function destroyChatEntity(Request $request, $type, $id)
    {
        $entity = $this->findOwnedEntity($request, $type, $id);
        $entity->delete();

        return response()->json(['deleted' => true]);
    }

    /**
     * Kanalga bog'langan chatni o'chiradi.
     * MUHIM: endi Chat jadvalidagi haqiqiy yozuvni ham o'chiramiz
     * (u bilan bog'liq entity_messages'lar ham cascade orqali o'chadi).
     */
    public function deleteChat(Request $request, $type, $id)
    {
        $entity = $this->findOwnedEntity($request, $type, $id);
        abort_unless($entity->type === 'channel', 404);

        if ($entity->chat) {
            $entity->chat->delete();
        }

        $entity->update([
            'chat_name' => null,
            'chat_username' => null,
            'chat_avatar' => null,
            'chat_description' => null,
            'chat_created_at' => null,
        ]);

        return response()->json(['deleted' => true]);
    }

    public function deleteChatEntity(Request $request, $type, $id)
    {
        $entity = $this->findOwnedEntity($request, $type, $id);
        $entity->delete();

        return response()->json(['deleted' => true]);
    }

    public function moveChatEntityHome(Request $request, $type, $id)
    {
        $entity = $this->findOwnedEntity($request, $type, $id);
        $entity->update(['in_home' => true]);

        return response()->json(['entity' => $entity->fresh()]);
    }

    public function contacts()
    {
        return $this->page('Kontaktlar', 'contacts');
    }

    public function calls()
    {
        return view('menu.calls');
    }

    public function saved()
    {
        return $this->page('Saqlangan xabarlar', 'saved');
    }

  public function settings()
{
    $user = request()->user();
    $settings = UserSettings::for($user);

    $locale = $settings['language'] ?? 'uz';
    if (in_array($locale, ['uz', 'ko', 'ru', 'en'], true)) {
        session()->put('app_locale', $locale);
        app()->setLocale($locale);
    }

    $settings['wallpaper_image_url'] = !empty($settings['wallpaper_image_path'])
        ? Storage::disk('public')->url($settings['wallpaper_image_path'])
        : null;

 $settings['wallpaper_video_url'] = !empty($settings['wallpaper_video_path'])
    ? asset('storage/' . ltrim($settings['wallpaper_video_path'], '/'))
    : null;

    $settings['wallpaper_current_url'] = ($settings['wallpaper_type'] ?? '') === 'video'
        ? $settings['wallpaper_video_url']
        : $settings['wallpaper_image_url'];

    $storage = $this->storageBreakdown($user);

    return view('menu.settings', compact('settings', 'storage'));
}

    public function updateSettings(Request $request)
    {
        $hex = ['nullable', 'regex:/^#[0-9a-fA-F]{6}$/'];
        $vis = ['nullable', Rule::in(['everyone', 'contacts', 'nobody'])];
        $time = ['nullable', 'regex:/^([01]\d|2[0-3]):[0-5]\d$/'];

        $request->validate([
            'theme' => ['required', Rule::in(['dark', 'light', 'system'])],
            'accent_color' => ['nullable', Rule::in(['default', 'amber', 'teal', 'blue', 'violet', 'rose', 'green', 'custom'])],
            'accent_custom_color' => $hex,
            'density' => ['nullable', Rule::in(['comfortable', 'compact'])],
            'font_size' => ['nullable', 'integer', 'min:13', 'max:19'],

            'wallpaper_type' => ['nullable', Rule::in(['gradient', 'color', 'image', 'video'])],
            'wallpaper_gradient' => ['nullable', Rule::in(['sunset', 'mint', 'dusk', 'berry', 'forest', 'amber', 'ocean', 'mono', 'candy', 'night', 'lime', 'rose'])],
            'wallpaper_color' => $hex,
            'wallpaper_color_mid' => $hex,
            'wallpaper_color_bottom' => $hex,
            'wallpaper_color_style' => ['nullable', Rule::in(['v', 'd', 'h', 'r'])],
            'wallpaper_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'wallpaper_video' => ['nullable', 'file', 'mimes:mp4,webm', 'max:460800'],
            'wallpaper_video_x' => ['nullable', 'integer', 'min:0', 'max:100'],
            'wallpaper_video_y' => ['nullable', 'integer', 'min:0', 'max:100'],

            'notif_position' => ['nullable', Rule::in(['top-left', 'top-center', 'top-right', 'bottom-left', 'bottom-center', 'bottom-right'])],
            'notif_style' => ['nullable', Rule::in(['card', 'compact', 'minimal'])],
            'notif_duration' => ['nullable', 'integer', 'min:3', 'max:15'],

            'quiet_hours_start' => $time,
            'quiet_hours_end' => $time,
            'quiet_hours_message' => ['nullable', 'string', 'max:180'],

            'profile_visibility' => $vis,
            'profile_photo_visibility' => $vis,
            'bio_visibility' => $vis,
            'last_seen_visibility' => $vis,
            'online_visibility' => $vis,
            'who_can_message' => $vis,
            'who_can_add_groups' => $vis,
            'auto_lock' => ['nullable', Rule::in(['never', '5', '15', '60'])],

            'autodownload_wifi' => ['nullable', 'array'],
            'autodownload_wifi.*' => [Rule::in(['images', 'videos', 'files', 'voice', 'links'])],
            'autodownload_mobile' => ['nullable', 'array'],
            'autodownload_mobile.*' => [Rule::in(['images', 'videos', 'files', 'voice', 'links'])],

            'language' => ['nullable', Rule::in(['uz', 'ko', 'ru', 'en'])],
            'date_format' => ['nullable', Rule::in(['dmy', 'mdy', 'ymd'])],
        ]);

        $user = $request->user();
        $new = UserSettings::for($user);

        // oddiy matnli maydonlar
        $strings = [
            'theme', 'accent_color', 'accent_custom_color', 'density',
            'wallpaper_type', 'wallpaper_gradient', 'wallpaper_color', 'wallpaper_color_mid',
            'wallpaper_color_bottom', 'wallpaper_color_style',
            'notif_position', 'notif_style', 'quiet_hours_start', 'quiet_hours_end',
            'profile_visibility', 'profile_photo_visibility', 'bio_visibility',
            'last_seen_visibility', 'online_visibility', 'who_can_message', 'who_can_add_groups',
            'auto_lock', 'language', 'date_format',
        ];
        foreach ($strings as $key) {
            if ($request->filled($key)) {
                $new[$key] = $request->input($key);
            }
        }

        foreach (['font_size', 'notif_duration', 'wallpaper_video_x', 'wallpaper_video_y'] as $key) {
            if ($request->filled($key)) {
                $new[$key] = (int) $request->input($key);
            }
        }

        // checkbox'lar: belgilanmasa yuborilmaydi -> false
        $checkboxes = [
            'wallpaper_blur', 'notifications', 'sound', 'notif_preview', 'notif_show_sender',
            'notif_show_avatar', 'notif_system', 'group_notifications', 'enter_to_send',
            'read_receipts', 'quiet_hours_enabled', 'two_factor', 'login_alerts', 'anthem_autoplay',
        ];
        foreach ($checkboxes as $key) {
            $new[$key] = $request->boolean($key);
        }
        if ($request->has('time_format_24h')) {
            $new['time_format_24h'] = $request->boolean('time_format_24h');
        }

        $new['quiet_hours_message'] = trim((string) $request->input('quiet_hours_message')) !== ''
            ? $request->input('quiet_hours_message')
            : UserSettings::defaults()['quiet_hours_message'];

        $allowedDl = ['images', 'videos', 'files', 'voice', 'links'];
        $new['autodownload_wifi'] = array_values(array_intersect($allowedDl, (array) $request->input('autodownload_wifi', [])));
        $new['autodownload_mobile'] = array_values(array_intersect($allowedDl, (array) $request->input('autodownload_mobile', [])));

        // fon rasmi / videosi
        if ($request->hasFile('wallpaper_image')) {
            if (!empty($new['wallpaper_image_path'])) {
                Storage::disk('public')->delete($new['wallpaper_image_path']);
            }
            $new['wallpaper_image_path'] = $request->file('wallpaper_image')->store('wallpapers', 'public');
        }
        if ($request->hasFile('wallpaper_video')) {
            if (!empty($new['wallpaper_video_path'])) {
                Storage::disk('public')->delete($new['wallpaper_video_path']);
            }
            $new['wallpaper_video_path'] = $request->file('wallpaper_video')->store('wallpapers', 'public');
        }

        $user->update(['settings' => $new]);

        $locale = $new['language'] ?? 'uz';
        if (in_array($locale, ['uz', 'ko', 'ru', 'en'], true)) {
            session()->put('app_locale', $locale);
            app()->setLocale($locale);
        }

// Suhbatdoshlar ko'rishi uchun xabar rangini alohida ustunda ham saqlaymiz
if ($request->has('accent_color')) {
    $named = [
        'amber' => '#e0a83e', 'teal' => '#2dd4bf', 'blue' => '#4b9bea',
        'violet' => '#a78bfa', 'rose' => '#f472b6', 'green' => '#34d399',
    ];
    $choice = $request->input('accent_color');
    $bubbleHex = $choice === 'custom'
        ? $request->input('accent_custom_color')
        : ($named[$choice] ?? null);

    if ($bubbleHex && !preg_match('/^#[0-9a-fA-F]{6}$/', $bubbleHex)) {
        $bubbleHex = null;
    }

    $user->forceFill(['bubble_color' => $bubbleHex])->save();
}


        return redirect()->route('settings')->with('status', 'Sozlamalar saqlandi.');
    }

    /** Xotira: foydalanuvchi yuborgan fayllar hajmi (MB) */
    private function storageBreakdown($user)
    {
        $files = Message::where('sender_id', $user->id)->whereNotNull('file_path')->get(['file_mime', 'file_size'])
            ->concat(SavedMessage::where('user_id', $user->id)->whereNotNull('file_path')->get(['file_mime', 'file_size']));

        $bytes = ['images' => 0, 'videos' => 0, 'files' => 0];
        foreach ($files as $f) {
            $mime = (string) $f->file_mime;
            $size = (int) $f->file_size;
            if (strpos($mime, 'image/') === 0) $bytes['images'] += $size;
            elseif (strpos($mime, 'video/') === 0) $bytes['videos'] += $size;
            else $bytes['files'] += $size;
        }
        $mb = function ($b) { return round($b / 1048576, 1); };

        return [
            ['key' => 'images', 'label' => 'Rasmlar', 'mb' => $mb($bytes['images']), 'color' => '#4b9bea'],
            ['key' => 'videos', 'label' => 'Videolar', 'mb' => $mb($bytes['videos']), 'color' => 'var(--accent)'],
            ['key' => 'files', 'label' => 'Fayllar', 'mb' => $mb($bytes['files']), 'color' => '#a78bfa'],
            ['key' => 'cache', 'label' => 'Kesh', 'mb' => 0, 'color' => '#6b6b5c'],
        ];
    }

    public function exportData(Request $request)
    {
        $user = $request->user();

        $payload = [
            'profile' => $user->only(['name', 'surname', 'username', 'email', 'phone', 'bio', 'created_at']),
            'settings' => UserSettings::for($user),
            'sent_messages' => Message::where('sender_id', $user->id)
                ->get(['receiver_id', 'body', 'file_name', 'created_at']),
            'saved_messages' => SavedMessage::where('user_id', $user->id)
                ->get(['body', 'file_name', 'created_at']),
        ];

        return response()->json($payload, 200, [
            'Content-Disposition' => 'attachment; filename="chatovbs-data.json"',
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function logoutOthers(Request $request)
    {
        $request->validate(['password' => ['required', 'string']]);

        if (!Hash::check($request->password, $request->user()->password)) {
            return response()->json(['message' => "Parol noto'g'ri."], 422);
        }

        Auth::logoutOtherDevices($request->password);

        return response()->json(['ok' => true]);
    }

    public function deleteAccount(Request $request)
    {
        $request->validate(['password' => ['required', 'string']]);
        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['message' => "Parol noto'g'ri."], 422);
        }

        DB::transaction(function () use ($user) {
            Message::where('sender_id', $user->id)->orWhere('receiver_id', $user->id)->delete();
            SavedMessage::where('user_id', $user->id)->delete();

            foreach (Story::where('user_id', $user->id)->get() as $story) {
                Storage::disk('public')->delete($story->media_path);
                $story->delete();
            }
            ChatEntity::where('user_id', $user->id)->get()->each->delete();

            foreach ([$user->avatar, $user->settings['wallpaper_image_path'] ?? null, $user->settings['wallpaper_video_path'] ?? null] as $path) {
                if ($path) Storage::disk('public')->delete($path);
            }
        });

        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['ok' => true]);
    }

    private function page($title, $section)
    {
        return view('menu.page', compact('title', 'section'));
    }

    private function currentUserStories()
    {
        return auth()->user()->stories()->with('viewers')->latest()->get();
    }

    private function getChatEntities($type)
    {
        return auth()->user()->chatEntities()->where('type', $type)->with('chat')->latest()->get();
    }
}
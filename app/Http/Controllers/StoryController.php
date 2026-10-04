<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoryController extends Controller
{
    const MAX_STORIES = 32;
    const COOLDOWN_HOURS = 24;

    /**
     * Yangi istoriya (rasm yoki video) yuklash.
     */
    public function store(Request $request)
    {
        $userId = auth()->id();

        // 32 tadan oshmasin
        $currentCount = Story::where('user_id', $userId)->count();
        if ($currentCount >= self::MAX_STORIES) {
            return response()->json([
                'success' => false,
                'message' => "Siz " . self::MAX_STORIES . " tadan ortiq istoriya joylay olmaysiz. Avval eski istoriyalardan birini o'chiring.",
            ], 422);
        }

        // Kuniga faqat 1 marta yuklash mumkin
        $lastStory = Story::where('user_id', $userId)->latest()->first();
        if ($lastStory) {
            $hoursSinceLast = $lastStory->created_at->diffInHours(now());
            if ($hoursSinceLast < self::COOLDOWN_HOURS) {
                $hoursLeft = self::COOLDOWN_HOURS - $hoursSinceLast;
                return response()->json([
                    'success' => false,
                    'message' => "Siz kuniga faqat 1 marta istoriya joylay olasiz. Yana taxminan {$hoursLeft} soatdan keyin urinib ko'ring.",
                ], 422);
            }
        }

        $request->validate([
            'story'   => 'required|file|mimes:jpg,jpeg,png,gif,webp,bmp,avif,mp4,mov,avi,webm,mkv,m4v,wmv,flv,ogv|max:153600', // 150MB
            'caption' => 'nullable|string|max:200',
        ]);

        $file = $request->file('story');

        if (!$file->isValid()) {
            return response()->json([
                'success' => false,
                'message' => "Fayl yuklashda xatolik yuz berdi. Fayl hajmi serverdagi limitdan (150MB) katta bo'lishi mumkin.",
            ], 422);
        }

        $originalExtension = strtolower($file->getClientOriginalExtension());
        if (!$originalExtension) {
            $originalExtension = strtolower($file->extension()) ?: 'bin';
        }

        $videoExtensions = ['mp4', 'mov', 'avi', 'webm', 'mkv', '3gp', 'm4v', 'wmv', 'flv', 'ogv'];
        $isVideo = in_array($originalExtension, $videoExtensions, true);

        $filename = uniqid('story_', true) . '.' . $originalExtension;
        $path = $file->storeAs('stories', $filename, 'public');

        $story = Story::create([
            'user_id'    => $userId,
            'media_path' => $path,
            'type'       => $isVideo ? 'video' : 'image',
            'duration'   => null,
            'caption'    => $request->input('caption'),
        ]);

        return response()->json([
            'success' => true,
            'story'   => $story,
        ]);
    }

    /**
     * Istoriyani o'chirish.
     */
    public function destroy(Story $story)
    {
        if ($story->user_id !== auth()->id()) {
            abort(403, "Bu istoriyani o'chirishga ruxsatingiz yo'q.");
        }

        Storage::disk('public')->delete($story->media_path);
        $story->delete();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Istoriyani "ko'rilgan" deb belgilash.
     * Bu route istoriya ochilganda (viewer'da) frontenddan chaqiriladi.
     * Egasi o'z istoriyasini ochsa, hisoblanmaydi.
     */
    public function registerView(Story $story)
    {
        $userId = auth()->id();

        // O'z istoriyasini ko'rsa — sanalmaydi
        if ($story->user_id === $userId) {
            return response()->json([
                'success' => true,
                'counted' => false,
            ]);
        }

        // Mavjud bo'lmasa yaratadi; mavjud bo'lsa — vaqtini o'zgartirmaydi
        $view = $story->views()->firstOrCreate([
            'user_id' => $userId,
        ]);

        return response()->json([
            'success' => true,
            'counted' => true,
            'views_count' => $story->views()->count(),
        ]);
    }

    /**
     * Istoriyaga reaksiya (masalan yurakcha) qo'yish yoki o'zgartirish.
     */
    public function react(Request $request, Story $story)
    {
        $request->validate([
            'reaction' => 'required|string|max:8',
        ]);

        $userId = auth()->id();

        if ($story->user_id === $userId) {
            return response()->json([
                'success' => false,
                'message' => "O'z istoriyangizga reaksiya qo'ya olmaysiz.",
            ], 422);
        }

        $story->views()->updateOrCreate(
            ['user_id' => $userId],
            ['reaction' => $request->input('reaction')]
        );

        return response()->json([
            'success' => true,
        ]);
    }
}
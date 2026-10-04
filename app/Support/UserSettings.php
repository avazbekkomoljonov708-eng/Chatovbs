<?php

namespace App\Support;

class UserSettings
{
    public static function defaults()
    {
        return [
            'theme' => 'dark',
            'accent_color' => 'default',
            'accent_custom_color' => '#e0a83e',
            'density' => 'comfortable',
            'font_size' => 15,

            'wallpaper_type' => 'gradient',
            'wallpaper_gradient' => 'sunset',
            'wallpaper_color' => '#1d1d17',
            'wallpaper_color_mid' => '#302b63',
            'wallpaper_color_bottom' => '#0f0c29',
            'wallpaper_color_style' => 'v',
            'wallpaper_blur' => false,
            'wallpaper_image_path' => null,
            'wallpaper_video_path' => null,
            'wallpaper_video_x' => 50,
            'wallpaper_video_y' => 50,

            'notifications' => true,
            'sound' => true,
            'notif_preview' => true,
            'notif_show_sender' => true,
            'notif_show_avatar' => true,
            'notif_system' => false,
            'group_notifications' => true,
            'notif_position' => 'bottom-right',
            'notif_style' => 'card',
            'notif_duration' => 6,
            'enter_to_send' => true,
            'read_receipts' => true,

            'quiet_hours_enabled' => true,
            'quiet_hours_start' => '06:00',
            'quiet_hours_end' => '22:00',
            'quiet_hours_message' => "Bugungi yozishmalar vaqti tugadi. Dam olishingizni so'raymiz 🌙",

            'profile_visibility' => 'everyone',
            'profile_photo_visibility' => 'everyone',
            'bio_visibility' => 'everyone',
            'last_seen_visibility' => 'everyone',
            'online_visibility' => 'everyone',
            'who_can_message' => 'everyone',
            'who_can_add_groups' => 'everyone',
            'auto_lock' => 'never',
            'two_factor' => false,
            'login_alerts' => true,

            'autodownload_wifi' => ['images', 'videos', 'files', 'voice', 'links'],
            'autodownload_mobile' => ['images', 'voice', 'links'],

            'language' => 'uz',
            'date_format' => 'dmy',
            'time_format_24h' => true,
            'anthem_autoplay' => true,
        ];
    }

    public static function for($user)
    {
        $stored = ($user && is_array($user->settings)) ? $user->settings : [];
        return array_merge(self::defaults(), $stored);
    }
}
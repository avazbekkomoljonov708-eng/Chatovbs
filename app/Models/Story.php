<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    /**
     * Mass assignment uchun ruxsat etilgan maydonlar.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'media_path',
        'type',
        'duration',
        'caption',
    ];

    /**
     * Bu istoriya qaysi foydalanuvchiga tegishli.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Bu istoriyaga tegishli barcha "ko'rish" yozuvlari (story_views jadvali).
     */
    public function views()
    {
        return $this->hasMany(StoryView::class);
    }

    /**
     * Bu istoriyani kimlar ko'rgani (foydalanuvchilar ro'yxati),
     * har birining ko'rgan vaqti va reaksiyasi bilan birga.
     */
    public function viewers()
    {
        return $this->belongsToMany(User::class, 'story_views')
            ->withPivot('reaction')
            ->withTimestamps();
    }
}
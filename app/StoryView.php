<?php

namespace App;

use App\Models\Story;
use Illuminate\Database\Eloquent\Model;

class StoryView extends Model
{
    /**
     * Mass assignment uchun ruxsat etilgan maydonlar.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'story_id',
        'user_id',
        'reaction',
    ];

    /**
     * Bu ko'rish yozuvi qaysi istoriyaga tegishli.
     */
    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    /**
     * Bu istoriyani kim ko'rgan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
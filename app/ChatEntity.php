<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatEntity extends Model
{
    protected $fillable = [
        'user_id', 'type', 'name', 'username', 'description', 'visibility', 'avatar', 'members_count',
        'chat_name', 'chat_username', 'chat_avatar', 'chat_description', 'chat_created_at', 'in_home', 'profile_linked',
    ];

    protected $casts = [
        'chat_created_at' => 'datetime',
        'in_home' => 'boolean',
        'profile_linked' => 'boolean',
    ];

    public function chat()
    {
        return $this->hasOne(Chat::class, 'chat_entity_id');
    }
}
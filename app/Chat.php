<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'chat_entity_id',
        'name',
        'username',
        'avatar',
        'description',
        'chat_created_at',
    ];

    protected $casts = [
        'chat_created_at' => 'datetime',
    ];

    public function entity()
    {
        return $this->belongsTo(ChatEntity::class, 'chat_entity_id');
    }

    public function messages()
    {
        return $this->hasMany(EntityMessage::class, 'chat_id');
    }
}
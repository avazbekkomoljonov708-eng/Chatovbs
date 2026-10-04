<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntityMessage extends Model
{
   protected $fillable = ['chat_entity_id', 'chat_id', 'is_channel_post', 'sender_id', 'body', 'audio_path', 'audio_duration', 'file_path', 'file_name', 'file_mime', 'file_size'];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function views()
    {
        return $this->hasMany(EntityMessageView::class);
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }


    public function entity()
    {
        return $this->belongsTo(ChatEntity::class, 'chat_entity_id');
    }
}
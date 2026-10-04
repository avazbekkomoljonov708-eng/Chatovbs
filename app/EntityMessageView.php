<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntityMessageView extends Model
{
    protected $fillable = [
        'entity_message_id',
        'user_id',
    ];

    public function entityMessage()
    {
        return $this->belongsTo(EntityMessage::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavedMessage extends Model
{
    protected $fillable = [
        'user_id',
        'body',
        'audio_path',
        'audio_duration',
        'file_path',
        'file_name',
        'file_mime',
        'file_size',
    ];
}
<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Story;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
        protected $fillable = [
    'name', 'surname', 'phone', 'email', 'username', 'bio', 'avatar', 'password', 'is_verified', 'settings',
    'show_phone', 'show_email', 'bubble_color',
];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'settings' => 'array',
    ];

    public function stories()
    {
        return $this->hasMany(Story::class);
    }

    public function chatEntities()
    {
        return $this->hasMany(ChatEntity::class);
    }
}
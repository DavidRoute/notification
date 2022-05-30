<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'device_token',
        'os_type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relationships.
     */
    public function channels() 
    {
        return $this->belongsToMany(Channel::class, 'subscribe_channel')->withTimestamps();
    }


    /**
     * Helper methods.
     */
    public function subscribe(Channel $channel) 
    {
        return $this->channels()->attach($channel);
    }

    public function unsubscribe(Channel $channel) 
    {
        return $this->channels()->detach($channel);
    }

    public function allUnsubscribe() 
    {
        return $this->channels()->update(['active' => false]);
    }

    public function resubscribe() 
    {
        return $this->channels()->update(['active' => true]);
    }
}

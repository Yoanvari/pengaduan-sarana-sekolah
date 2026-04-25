<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama', 
        'username', 
        'password'
    ];

    protected $hidden = ['password'];

    public function handleAspirasis()
    {
        return $this->hasMany(Aspirasi::class, 'admin_id');
    }
}
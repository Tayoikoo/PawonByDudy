<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $guarded = 'user';
    public $timestamps = false;

    protected $fillable = [
        'username', 'email', 'password', 'hp', 'role', 'status'
    ];

    protected $hidden = ['password'];
}

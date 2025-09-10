<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    
    protected $primaryKey = 'id_user';


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'id_role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
     protected $hidden = [
        'password',

    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id_role');
    }
}

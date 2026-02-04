<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_token', 'username', 'password', 'email', 'verified_at', 'role_id', 'organization_id', 'external_id', 'external_auth', 'created_at', 'updated_at',
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userToken()
    {
        return $this->hasOne(UserToken::class, 'user_id', 'user_id');
    }

    public function cetiStudent()
    {
        return $this->hasOne(CetiStudent::class, 'user_id', 'user_id');
    }

    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'role_id');
    }
}

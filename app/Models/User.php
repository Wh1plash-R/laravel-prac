<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function learner()
    {
        return $this->hasOne(Learner::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function instructor()
    {
        return $this->hasOne(Instructor::class);
    }

    public function hasRole($role)
    {
        return $this->role->name === $role;
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }

    public function isUser()
    {
        return $this->hasRole('user');
    }

    public function isInstructor()
    {
        return $this->hasRole('instructor');
    }

    /**
     * Get the profile picture as base64 encoded string
     */
    public function getProfilePictureBase64()
    {
        if ($this->profile_picture) {
            return base64_encode($this->profile_picture);
        }
        return null;
    }

    /**
     * Check if user has a profile picture
     */
    public function hasProfilePicture()
    {
        return !empty($this->profile_picture);
    }
}

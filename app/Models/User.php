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

    public function getProfilePictureUrlAttribute()
    {
        if (empty($this->profile_picture)) {
            return null;
        }

        $bin = $this->profile_picture;
        $mime = 'image/jpeg';

        if (strncmp($bin, "\x89PNG\x0D\x0A\x1A\x0A", 8) === 0) {
            $mime = 'image/png';
        }

        elseif (strncmp($bin, "\xFF\xD8\xFF", 3) === 0) {
            $mime = 'image/jpeg';
        }

        elseif (strncmp($bin, 'GIF87a', 6) === 0 || strncmp($bin, 'GIF89a', 6) === 0) {
            $mime = 'image/gif';
        }

        elseif (strncmp($bin, 'RIFF', 4) === 0 && strpos(substr($bin, 8, 4), 'WEBP') !== false) {
            $mime = 'image/webp';
        }

        return 'data:' . $mime . ';base64,' . base64_encode($bin);
    }
}

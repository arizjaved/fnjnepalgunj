<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function createdPhotos()
    {
        return $this->hasMany(PhotoGallery::class, 'created_by');
    }

    public function createdVideos()
    {
        return $this->hasMany(VideoGallery::class, 'created_by');
    }

    public function approvedMemberships()
    {
        return $this->hasMany(Membership::class, 'approved_by');
    }
}
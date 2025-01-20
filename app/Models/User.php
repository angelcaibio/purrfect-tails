<?php

namespace App\Models;

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
        'username',
        'role',
        'email',
        'password',
        'profile_picture',  // To store profile picture URL
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

    public $timestamps = false; // Disable timestamps if you're not using them

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Define the relationship between User and Likes.
     * A user can like many posts.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Check if the user has liked a specific post.
     */
    public function hasLiked($postId)
    {
        return $this->likes()->where('post_id', $postId)->exists();
    }

    /**
     * Define the relationship between User and Posts.
     * A user can create many posts.
     */
    public function posts()
    {
        return $this->hasMany(Blog::class);
    }
}



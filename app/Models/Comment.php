<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Comment extends Model
{
    protected $table = 'comments';

    // Define the primary key if it's not the default 'id'
    protected $primaryKey = 'id';

    // Define the fillable attributes for mass assignment
    protected $fillable = ['post_id', 'user_id', 'comment', 'created_at'];

    // Disable automatic handling of timestamps (if you don't want created_at and updated_at)
    public $timestamps = false;

    // Optionally, cast created_at to Carbon for automatic date parsing
    protected $dates = ['created_at'];

    // Define the relationship with the Post model (one comment belongs to one post)
    public function post()
    {
        return $this->belongsTo(Blog::class, 'post_id');
    }

    // Define the relationship with the User model (one comment belongs to one user)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Method to return a human-readable format of created_at
    public function getCreatedAtAttribute($value)
    {
        // Return the formatted date as 'Month day, Year - hour:minute AM/PM'
        return \Carbon\Carbon::parse($value)->format('F j, Y \a\t h:i A');
    }
}

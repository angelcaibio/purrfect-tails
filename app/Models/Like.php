<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    // Define the table name if it's different from the model's default plural form
    protected $table = 'likes';

    // Specify the primary key if it's different from the default 'id'
    protected $primaryKey = 'id';

    // Set the fillable attributes (columns that can be mass assigned)
    protected $fillable = [
        'post_id',
        'user_id',
    ];

    public $timestamps = false;

    // Define the relationships

    // A like belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // A like belongs to a post
    public function post()
    {
        return $this->belongsTo(Blog::class);
    }
}

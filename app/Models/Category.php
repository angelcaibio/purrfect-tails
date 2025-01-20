<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = ['name', 'created_at'];

    // Disable automatic timestamps
    public $timestamps = false; // Disable default created_at and updated_at

    // Define the inverse relationship with the Blog model
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
}


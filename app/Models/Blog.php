<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'posts'; // Make sure this matches your database table

    protected $fillable = [
        'title',
        'content',
        'category_id',
        'user_id',
        'author',
        'photo',
        'tags', 
    ];

    protected $casts = [
        'photo' => 'string', 
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Define a relationship to the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define a many-to-many relationship to the Tag model.
     */
// In Blog.php (the Blog model)
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to filter by category.
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope to search blogs by title or content.
     */
    public function scopeSearch($query, $searchTerm)
    {
        return $query->where('title', 'LIKE', "%{$searchTerm}%")
                     ->orWhere('content', 'LIKE', "%{$searchTerm}%");
    }

    /**
     * Accessor for the first photo in the `photo` field (if it's an array).
     */
    public function getFirstPhotoAttribute()
    {
        return $this->photo ? $this->photo[0] : 'default.jpg';  // Default photo if no photo is available
    }

    /**
     * Mutator for ensuring photos are stored as an array (if storing multiple photos).
     */
    public function setPhotoAttribute($value)
    {
        $this->attributes['photo'] = is_array($value) ? json_encode($value) : $value;  // Ensure storing as JSON if array
    }
}

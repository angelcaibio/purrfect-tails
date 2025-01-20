<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Blog;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share categories with all views
        View::share('categories', Category::all());
        View::share('recentPosts', Blog::latest()->take(3)->get());
        View::share('tags', Tag::all());
    }

    public function register()
    {
        //
    }
}

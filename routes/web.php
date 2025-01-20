<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

// ----------------------------
// Authentication Routes
// ----------------------------
Auth::routes();

// Default Route
Route::get('/', [HomeController::class, 'index'])->name('user.index');
Route::get('/home', [HomeController::class, 'index']); // Same logic, handled by HomeController@index

// ----------------------------
// User Auth Routes
// ----------------------------
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('user.login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('admin/register', [RegisterController::class, 'showAdminRegistrationForm'])->name('admin.register');
Route::post('admin/register', [RegisterController::class, 'adminRegister']);

// ----------------------------
// Admin Auth Routes
// ----------------------------
Route::get('/admin/login', [LoginController::class, 'showAdminLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'adminLogin']);
Route::post('/admin/logout', [LoginController::class, 'adminLogout'])->name('admin.logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);


// ----------------------------
// Admin Protected Routes
// ----------------------------
Route::middleware('admin')->group(function () {
    // Admin Dashboard
    Route::get('/admin', [PageController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/dashboard', [PageController::class, 'dashboard']);

    // User Management
    Route::resource('users', UserController::class);
    Route::get('/admin/users', [PageController::class, 'users'])->name('admin.users');

    // Pages
    Route::get('/admin/page1', [PageController::class, 'page1'])->name('admin.page1');
    Route::get('/admin/comments', [PageController::class, 'comments'])->name('admin.comments');
    Route::get('/admin/media_library', [PageController::class, 'mediaLibrary'])->name('admin.mediaLibrary');

    // Blogs
    Route::resource('blogs', BlogController::class);
    Route::get('/admin/blogs', [BlogController::class, 'index'])->name('admin.blogs');
    Route::get('/admin/blogs/{id}', [BlogController::class, 'show'])->name('admin.blog');
    Route::delete('/blogs/{blog}/delete-photo', [BlogController::class, 'deletePhoto'])->name('blogs.delete-photo');

    // Categories
    Route::resource('categories', CategoryController::class);
    Route::get('/admin/categories', [CategoryController::class, 'index'])->name('admin.categories');

    // Tags
    Route::resource('tags', TagController::class);
    Route::get('/admin/tags', [TagController::class, 'index'])->name('admin.tags');

    //Comment
    Route::delete('admin/comments/{id}', [PageController::class, 'deleteComment'])->name('comment.remove');
});

// ----------------------------
// Authenticated User Routes
// ----------------------------
Route::middleware('auth')->group(function () {
    Route::post('like/{postId}', [HomeController::class, 'likePost'])->name('likePost');
    Route::post('/post/{postId}/comment', [HomeController::class, 'storeComment'])->name('comment.store');
    Route::delete('/comment/{comment}', [HomeController::class, 'destroyComment'])->name('comment.delete');
    
});

// ----------------------------
// Social Login Routes
// ----------------------------
Route::get('login/google', [SocialLoginController::class, 'redirectToGoogle']);
Route::get('login/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);
Route::get('login/facebook', [SocialLoginController::class, 'redirectToFacebook']);
Route::get('login/facebook/callback', [SocialLoginController::class, 'handleFacebookCallback']);

// ----------------------------
// Public Routes
// ----------------------------
Route::get('post/{postId}', [HomeController::class, 'showPost'])->name('post.show');
Route::get('category/{categoryId}', [HomeController::class, 'showCategory'])->name('users.category');
Route::get('/search', [HomeController::class, 'search'])->name('search');

<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class BlogController extends Controller
{

    public function index()
    {
        $posts = DB::table('posts')->orderBy('id')->paginate (5);
        return view('admin.blogs', compact('posts', ));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.create.blog', compact('categories', 'tags')); 
    }


    public function show($id)
{
    $post = Blog::find($id);


    if (!$post) {
        abort(404, 'Blog post not found');
    }

    $tag_ids = array_filter(array_map('trim', explode(',', $post->tags))); 
    $tags = Tag::whereIn('id', $tag_ids)->pluck('name');
    $category = Category::find($post->category_id);
    $category_name = $category ? $category->name : 'Unknown';
    

    $photos = [];
    if (!empty($post->photo)) {
        $photos = array_map(function ($photo) {
            return asset('posts/' . $photo); 
        }, explode(',', $post->photo));  
    }


    return view('admin.blog', compact('post', 'category_name', 'tags', 'photos'));
}

    
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'photos' => 'nullable|array',
            'photos.*' => 'file|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);
    
        DB::beginTransaction();
        try {
            $photo = '';  // Default value if no photos are uploaded
    
            if ($request->hasFile('photos')) {
                $photos = [];
                foreach ($request->file('photos') as $file) {
                    $fileName = uniqid() . '-' . $file->getClientOriginalName();
                    $file->storeAs('posts', $fileName, 'public');
                    $photos[] = $fileName;
                }
                $photo = implode(',', $photos);  
            }
            $blogPost = Blog::create([
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category,
                'user_id' => auth()->id(),
                'author' => auth()->user()->username ?? 'Anonymous',
                'tags' => $request->tags ? implode(',', $request->tags) : '',
                'photo' => $photo, 
            ]);
    
            DB::commit();
    
            return redirect()->route('admin.blogs')->with('success_message', 'Blog created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Blog creation failed: ' . $e->getMessage());
            return redirect()->route('admin.blogs')->with('error_message', 'Failed to create blog. Please try again.');
        }
    }
    
    
    public function edit(Blog $blog)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.edit.blog', compact('blog', 'categories', 'tags')); 
    }


    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category' => 'required|exists:categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
            'photos' => 'nullable|array',
            'photos.*' => 'file|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);
    
        DB::beginTransaction();
        try {
            $existingPhotos = $blog->photo ? explode(',', $blog->photo) : [];
    
            // Handle deleted photos
            if ($request->filled('deleted_photos')) {
                $deletedPhotos = explode(',', $request->deleted_photos);
                foreach ($deletedPhotos as $deletedPhoto) {
                    if (Storage::disk('public')->exists('posts/' . $deletedPhoto)) {
                        Storage::disk('public')->delete('posts/' . $deletedPhoto);
                    }
                }
                // Remove deleted photos from the existing list
                $existingPhotos = array_diff($existingPhotos, $deletedPhotos);
            }
    
            // Handle new photo uploads
            if ($request->hasFile('photos')) {
                $uploadedPhotos = [];
                foreach ($request->file('photos') as $file) {
                    $fileName = uniqid() . '-' . $file->getClientOriginalName();
                    $file->storeAs('posts', $fileName, 'public');
                    $uploadedPhotos[] = $fileName;
                }
                // Merge existing photos with newly uploaded ones
                $existingPhotos = array_merge($existingPhotos, $uploadedPhotos);
            }
    
            // Update blog details
            $blog->update([
                'title' => $request->title,
                'content' => $request->content,
                'category_id' => $request->category,
                'tags' => $request->tags ? implode(',', $request->tags) : '',
                'photo' => implode(',', $existingPhotos), // Save all remaining and new photos
            ]);
    
            DB::commit();
    
            return redirect()->route('admin.blogs')->with('success_message', 'Blog updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Blog update failed: ' . $e->getMessage());
            return redirect()->route('admin.blogs')->with('error_message', 'Failed to update blog. Please try again.');
        }
    }
    

  
    public function destroy(Blog $blog)
    {
        if ($blog->photo) {
            $photos = (is_array($blog->photo)) ? $blog->photo : explode(',', $blog->photo); // Convert to an array if it's a string
                        foreach ($photos as $photo) {
                if (Storage::disk('public')->exists('posts/' . $photo)) {
                    Storage::disk('public')->delete('posts/' . $photo);  // Delete the photo from storage
                }
            }
        }
        $blog->tags = '';  
        $blog->save();
            $blog->delete();
    
        return redirect()->route('admin.blogs')->with('success_message', 'Blog deleted successfully!');
    }
    
    
    public function deletePhoto(Request $request, Blog $blog)
    {
        $photoToDelete = $request->input('photo');

        if ($photoToDelete) {
            $existingPhotos = $blog->photo ? explode(',', $blog->photo) : [];

            if (in_array($photoToDelete, $existingPhotos)) {
                if (Storage::disk('public')->exists('posts/' . $photoToDelete)) {
                    Storage::disk('public')->delete('posts/' . $photoToDelete);
                }

                // Remove the photo from the database
                $remainingPhotos = array_diff($existingPhotos, [$photoToDelete]);
                $blog->photo = implode(',', $remainingPhotos);
                $blog->save();

                return response()->json(['success' => true, 'message' => 'Photo deleted successfully']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Photo could not be deleted'], 400);
    }




}

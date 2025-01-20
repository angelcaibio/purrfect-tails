<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use App\Models\Like;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Retrieve the latest posts
        $posts = Blog::orderBy('created_at', 'desc')->limit(6)->get();

        // Loop through posts and add the first photo URL to each post
        foreach ($posts as $post) {
            $photos = explode(',', $post->photo);
            $post->first_photo_url = asset('storage/posts/' . $photos[0]);
        }

        return view('users.index', compact('posts'));
    }

    public function showPost($postId)
    {
        $post = Blog::findOrFail($postId);

        $photos = explode(',', $post->photo);
        $background = !empty($photos[0]) ? 'storage/posts/' . trim($photos[0]) : 'storage/posts/default_background.jpg';
        $remaining_photos = array_map(function($photo) {
            return 'storage/posts/' . trim($photo);
        }, array_slice($photos, 1));

        $category = Category::find($post->category_id);
        $category_name = $category ? $category->name : 'Unknown';

        $tag_ids = array_filter(array_map('trim', explode(',', $post->tags)));
        $tags = Tag::whereIn('id', $tag_ids)->pluck('name')->toArray();

        $user = User::find($post->user_id);
        $author_image = 'storage/profile_picture/' . ($user->profile_picture ?? 'default.jpg');

        $background = asset($background);
        $author_image = asset($author_image);

        // Get like and comment counts
        $likeCount = Like::where('post_id', $postId)->count();
        $commentCount = Comment::where('post_id', $postId)->count();

        // Fetch comments and related data
        $comments = Comment::where('post_id', $postId)->latest()->get();
        foreach ($comments as &$comment) {
            $commentUser = User::find($comment->user_id);
            $comment->username = $commentUser->username ?? 'Anonymous';
            $comment->profile_picture = $commentUser->profile_picture 
                ? asset('storage/profile_picture/' . $commentUser->profile_picture) 
                : asset('storage/profile_picture/default.jpg');
        }
        return view('users.post', compact(
            'post', 'background', 'remaining_photos', 'category_name', 'tags', 
            'author_image', 'likeCount', 'commentCount', 'comments', ));
    }

    public function likePost($postId)
    {
        $post = Blog::findOrFail($postId);
        $user = auth()->user();

        $like = Like::where('post_id', $postId)->where('user_id', $user->id)->first();
    
        if ($like) {
            // Unlike the post if the user already liked it
            $like->delete();
            $liked = false;
        } else {
            // Like the post if the user hasn't liked it yet
            Like::create([
                'post_id' => $postId,
                'user_id' => $user->id
            ]);
            $liked = true;
        }
    
        // Get the updated like count
        $likeCount = Like::where('post_id', $postId)->count();
    
        // Return the response as JSON
        return response()->json([
            'liked' => $liked,
            'likeCount' => $likeCount
        ]);
    }

    public function showCategory($categoryId, Request $request)
    {

        $category = Category::findOrFail($categoryId);
        
        $resultsPerPage = 3;
        $page = $request->input('page', 1);
        $startFrom = ($page - 1) * $resultsPerPage;

        $posts = Blog::where('category_id', $categoryId)
            ->orderBy('created_at', 'desc')
            ->skip($startFrom)
            ->take($resultsPerPage)
            ->get();

        $totalPosts = Blog::where('category_id', $categoryId)->count();
        $totalPages = ceil($totalPosts / $resultsPerPage);
      
        return view('users.category', compact('category', 'posts', 'totalPages', 'page',));
    }

    public function search(Request $request)
{
    $query = $request->input('search_blog');


    $posts = Blog::where('title', 'like', '%' . $query . '%')
        ->get();

    return view('users.search', compact('posts', 'query'));
}

    // Handle Comment Store (for AJAX)
public function show($id)
    {
        $post = Blog::findOrFail($id);
        $comments = $post->comments()->latest()->get();

        return view('posts.show', compact('post', 'comments'));
    }

    public function storeComment(Request $request, $postId)
    {
        $validated = $request->validate([
            'comment' => 'required|string|max:255',  // Validate comment
        ]);
    
        // Save the comment to the database
        $comment = new Comment();
        $comment->post_id = $postId;
        $comment->user_id = auth()->id();
        $comment->comment = $validated['comment'];
        $comment->save();
    
        // Redirect back to the post page with success message
        return redirect()->route('post.show', $postId)->with('success', 'Comment added successfully!');
    }
    

    public function destroyComment($id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id !== auth()->id()) {
            return redirect()->route('post.show', $comment->post_id)->with('error', 'Unauthorized');
        }
        $comment->delete();
        return redirect()->route('post.show', $comment->post_id)->with('success', 'Comment deleted successfully!');
    }
    
    
}






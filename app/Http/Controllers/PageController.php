<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PageController extends Controller

{    
    public function page1()
    {
        $users = DB::table('users')->paginate(15);
        // $users = DB::table('users')->where(function($q) { $q->where('role', 'admin'); $q->orWhere('role', 'student'); }) ->get(['email','password']);
        // dd($users);
        return view('admin.page1', compact('users', ));
    }

    
    public function mediaLibrary()
    {
        $posts = DB::table('posts')->get(); 
        $existing_photos = [];
    
        foreach ($posts as $post) {
            if (!empty($post->photo)) {
                $photos = explode(',', $post->photo);
    
                foreach ($photos as $photo) {
                    $tag_ids = array_filter(array_map('trim', explode(',', $post->tags)));
                    $tags = [];
                    if (!empty($tag_ids)) {
                        $tags_data = DB::table('tags')->whereIn('id', $tag_ids)->pluck('name');
                        $tags = $tags_data->toArray();
                    }
                    $existing_photos[] = [
                        'photo' => 'posts/' . $photo,
                        'title' => $post->title,
                        'tags' => $tags
                    ];
                }
            }
        }
        return view('admin.media_library', compact('existing_photos'));
    }


    public function users()
    {
        $users = DB::table('users')
            ->where('role', 'user')
            ->select('id', 'profile_picture', 'username') 
            ->paginate(10);

        foreach ($users as $user) {
            $user->likes = DB::table('likes')
                ->where('user_id', $user->id)
                ->count();

            $user->comments = DB::table('comments')
                ->where('user_id', $user->id)
                ->count();
        }

        return view('admin.users', compact('users'));
    }
    public function comments()
    {
        $comments = DB::table('comments')
            ->join('users', 'comments.user_id', '=', 'users.id')
            ->join('posts', 'comments.post_id', '=', 'posts.id')
            ->select(
                'comments.id as comment_id',
                'comments.post_id',  // Add post_id to the select statement
                'users.username', 
                'users.profile_picture', 
                'posts.title as post_title', 
                'comments.comment as comment_text'
            )
            ->paginate(5);
    
        return view('admin.comments', compact('comments'));
    }
    
    
    public function dashboard()
{
    $totalPosts = DB::table('posts')->count();
    $totalUsers = DB::table('users')->where('role', 'user')->count();
    $totalComments = DB::table('comments')->count();

    $postsByCategory = DB::table('posts')
        ->select('category_id', DB::raw('COUNT(*) as count'))
        ->groupBy('category_id')
        ->get();

    $recentUsers = DB::table('users')
        ->select('id', 'username', 'created_at', 'profile_picture')
        ->where('created_at', '>=', now()->subWeek())
        ->where('role', 'user')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    $recentComments = DB::table('comments')
        ->select('id', 'post_id', 'user_id', 'comment', 'created_at')
        ->where('created_at', '>=', now()->subWeek())
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    $commentDetails = [];
    foreach ($recentComments as $comment) {
        $postTitle = DB::table('posts')->where('id', $comment->post_id)->value('title') ?? 'Unknown Post';
        $userDetails = DB::table('users')->where('id', $comment->user_id)->first();
        $commentDetails[] = [
            'comment' => $comment->comment,
            'created_at' => $comment->created_at,
            'post_title' => $postTitle,
            'username' => $userDetails->username ?? 'Unknown User',
            'profile_picture' => $userDetails->profile_picture ?? 'default.jpg',
        ];
    }

    return view('admin.dashboard', compact('totalPosts', 'totalUsers', 'totalComments', 'postsByCategory', 'recentUsers', 'commentDetails'));
}

public function deleteComment($id)
{
    $comment = DB::table('comments')->where('id', $id)->first();
    if (!$comment) {
        return redirect()->back()->with('error', 'Comment not found');
    }

    DB::table('comments')->where('id', $id)->delete();
    return redirect()->route('admin.comments')->with('success', 'Comment deleted successfully');
}



        
}

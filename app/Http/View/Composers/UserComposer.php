<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class UserComposer
{
    /**
     * Bind data to the view.
     *
     * @param \Illuminate\View\View $view
     * @return void
     */
    public function compose(View $view)
    {
        // Share the authenticated user's profile picture and username with all views
        if (Auth::check()) {
            $view->with('username', Auth::user()->username)
                 ->with('profile_picture', Auth::user()->profile_picture);
        }
    }
}

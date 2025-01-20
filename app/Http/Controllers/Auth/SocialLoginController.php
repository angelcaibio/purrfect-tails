<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import Log
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class SocialLoginController extends Controller
{
    // Redirect to Google login
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Create a new user if not found
                $user = User::create([
                    'username' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'profile_picture' => $googleUser->getAvatar(),
                    'role' => 'user',
                    'created_at' => date('Y-m-d H:i:s'),
                    'password' => null, 
                ]);
            }

            Auth::login($user, true); 
            return redirect()->route('home'); 
        } catch (\Exception $e) {
            // Log the error with more specific details
            Log::error('Google login error: ' . $e->getMessage());
            return redirect()->route('user.login')->withErrors(['login' => 'Error occurred during Google login. Please try again.']);
        }
    }

    // Redirect to Facebook login
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')
            ->redirect();
    }
    public function handleFacebookCallback()
    {
        try {
            // Retrieve user from Facebook
            $fbUser = Socialite::driver('facebook')->user();
    
            // Get profile picture URL (fallback method)
            $profilePicture = $fbUser->getAvatar() ?? "https://graph.facebook.com/{$fbUser->getId()}/picture?type=large";
    
            // Check or create user in the database
            $user = User::firstOrCreate(
                ['email' => $fbUser->getEmail()],
                [
                    'username' => $fbUser->getName(),
                    'profile_picture' => $profilePicture,
                    'role' => 'user',
                    'password' => null,
                    'created_at' => now(),
                ]
            );
    
            // Log in the user
            Auth::login($user, true);
    
            return redirect()->route('home'); // Redirect to home
        } catch (\Exception $e) {
            Log::error('Facebook login error: ' . $e->getMessage());
            return redirect()->route('user.login')->withErrors(['login' => 'Error occurred during Facebook login. Please try again.']);
        }
    }
    
    

}

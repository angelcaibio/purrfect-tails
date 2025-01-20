<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';
    public function __construct()
    {
        $this->middleware('guest');
    }

    // ------------------------
    // User Registration Functionality
    // ------------------------
    public function showRegistrationForm()
    {
        return view('auth.user.register');
    }

    public function register(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role
        ]);

        Auth::login($user, true);
        $this->setUserSession($user, 'user'); // Store user session
        return redirect()->route('/home');
    }

    // ------------------------
    // Admin Registration Functionality
    // ------------------------
    public function showAdminRegistrationForm()
    {
        return view('auth.admin.register');
    }

    public function adminRegister(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new admin user
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // Admin role
        ]);

        Auth::login($user, true);
        $this->setUserSession($user, 'admin'); // Store admin session
        return redirect()->route('admin.dashboard');
    }

    // ------------------------
    // Socialite: Google Registration
    // ------------------------
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'username' => $googleUser->getName(),
                'profile_picture' => $googleUser->getAvatar(),
                'role' => 'user',
                'password' => null,
            ]
        );

        Auth::login($user, true);
        $this->setUserSession($user, 'user');
        return redirect()->route('/home');
    }

    // ------------------------
    // Socialite: Facebook Registration
    // ------------------------
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $facebookUser = Socialite::driver('facebook')->user();

        $user = User::firstOrCreate(
            ['email' => $facebookUser->getEmail()],
            [
                'username' => $facebookUser->getName(),
                'profile_picture' => $facebookUser->getAvatar(),
                'role' => 'user',
            ]
        );

        Auth::login($user, true);
        $this->setUserSession($user, 'user');
        return redirect()->route('/home');
    }

    // ------------------------
    // Helper Methods
    // ------------------------
    private function setUserSession($user, $type)
    {
        if ($type == 'admin') {
            session(['admin' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'profile_picture' => $user->profile_picture,
                'role' => $user->role,
            ]]);
            session()->forget('user');
        } else {
            session(['user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'profile_picture' => $user->profile_picture,
                'role' => $user->role,
            ]]);
            session()->forget('admin');
        }
    }

    private function clearUserSession($type)
    {
        if ($type == 'admin') {
            session()->forget('admin');
        } else {
            session()->forget('user');
        }
    }
}

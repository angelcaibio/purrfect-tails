<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'adminLogout']);
        $this->middleware('auth')->only(['logout', 'adminLogout']);
    }

    // ------------------------
    // User Login Functionality
    // ------------------------
    public function showLoginForm()
    {
        return view('auth.user.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember'); // Check remember me option

        if (Auth::attempt($credentials, $remember)) {
            $this->setUserSession(Auth::user(), 'user'); // Store user session
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function logout(Request $request)
    {
        $this->clearUserSession('user'); // Clear user session
        return $this->performLogout($request, '/');
    }

    // ------------------------
    // Admin Login Functionality
    // ------------------------
    public function showAdminLoginForm()
    {
        return view('auth.admin.login');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Unauthorized access for admin login.']);
            }

            $this->setUserSession($user, 'admin'); // Store admin session
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records.']);
    }

    public function adminLogout(Request $request)
    {
        $this->clearUserSession('admin'); // Clear admin session
        return $this->performLogout($request, '/admin/login');
    }

    // ------------------------
    // Socialite: Google Login
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
        return redirect()->route('home');
    }

    // ------------------------
    // Socialite: Facebook Login
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
        return redirect()->route('home');
    }

    // ------------------------
    // Helper Methods
    // ------------------------
    private function setUserSession($user, $type)
    {
        if ($type == 'admin') {
            // Store admin-specific session data
            session(['admin' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'profile_picture' => $user->profile_picture,
                'role' => $user->role,
            ]]);
            session()->forget('user'); // Make sure the user session is cleared
        } else {
            // Store user-specific session data
            session(['user' => [
                'id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'profile_picture' => $user->profile_picture,
                'role' => $user->role,
            ]]);
            session()->forget('admin'); // Make sure the admin session is cleared
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

    private function performLogout(Request $request, $redirectPath)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect($redirectPath);
    }
}

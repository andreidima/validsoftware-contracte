<?php

namespace App\Http\Controllers\Auth;

use Socialite;
use App\User;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/';

    public function redirectTo()
    {
        // User role
        $role = auth()->user()->role;
        // dd($role);

        // Check user role
        switch ($role) {
            case 'superadmin':
                return '/clienti';
                break;
            case 'admin':
                return '/clienti';
                break;
            case 'service':
                return '/service/clienti';
                break;
            default:
                return '/login';
                break;
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function googleRedirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function googleHandleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }
        // only allow people with @company.com to login
        // if(explode("@", $user->email)[1] !== 'gmail.com'){
        //     return redirect()->to('/');
        // }
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if($existingUser){
        // log them in
            auth()->login($existingUser, true);
        } else {
        // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->provider        = 'Google';
            $newUser->provider_id     = $user->id;
            $newUser->avatar          = $user->avatar;
            $newUser->avatar_original = $user->avatar_original;
            $newUser->save();
            $newUser->roles()->attach(\App\Role::where('nume', 'demo')->get());
            auth()->login($newUser, true);
        }
        return redirect()->to('/');

        //$user = Socialite::with($service)->user();
        // $user = Socialite::driver('google')->stateless()->user();
        // dd($user);
        // return view('home')->withDetails($user)->withService('google');
    }

    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function facebookRedirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function facebookHandleProviderCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
        } catch (\Exception $e) {
            return redirect('/login');
        }
        // only allow people with @company.com to login
        // if(explode("@", $user->email)[1] !== 'gmail.com'){
        //     return redirect()->to('/');
        // }
        // check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        if ($existingUser) {
            // log them in
            auth()->login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->provider        = 'Facebook';
            $newUser->provider_id     = $user->id;
            $newUser->avatar          = $user->avatar;
            $newUser->avatar_original = $user->avatar_original;
            $newUser->save();
            $newUser->roles()->attach(\App\Role::where('nume', 'demo')->get());
            auth()->login($newUser, true);
        }
        return redirect()->to('/');

        //$user = Socialite::with($service)->user();
        // $user = Socialite::driver('google')->stateless()->user();
        // dd($user);
        // return view('home')->withDetails($user)->withService('google');
    }
}

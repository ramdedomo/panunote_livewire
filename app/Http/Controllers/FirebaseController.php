<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Sessions;
Use \Carbon\Carbon;
use App\Models\PanunoteUsers;
use Illuminate\Support\Facades\Auth;

class FirebaseController extends Controller
{
    protected $auth, $database;

    public function test(){
        $users = PanunoteUsers::all();
        return view('pages.test', ['users' => $users])->render();
    }


    public function signUp(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|exists:panunote_users,email,isverified,0',
            'password' => 'required|confirmed|min:6',
        ],[
            'email.exists' => 'This :attribute is already Registered and Verified.'
        ]);

            $user = PanunoteUsers::create([
                'email' => $request->email,
                'user_lname' => $request->lastname,
                'user_fname' => $request->firstname,
                'username' =>  $request->lastname.$request->firstname,
                'password' => Hash::make($request->password),
            ]);

            Auth::login($user);
            $request->session()->put('user_email', $request->email);
            return to_route('subjects');
    }

    public function signIn(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('user_email', $request->email);
            return to_route('subjects');
        }

        return back()->withErrors(['error' => ['Wrong Email or Password.']]);
    }

    public function signOut()
    {
        Auth::logout();
        return to_route('/');
    }






}

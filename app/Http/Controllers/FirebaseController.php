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
            'email' => 'required|email|unique:panunote_users',
            'password' => 'required|confirmed|min:6',
        ]);

        $newuser = PanunoteUsers::create([
            'email' => $request->email,
            'user_lname' => $request->lastname,
            'user_fname' => $request->firstname,
            'username' =>  $request->lastname.$request->firstname,
            'password' => Hash::make($request->password),
        ])->user_id;

        Session::put('USER_ID', $newuser);
        return to_route('subjects');
    }

    public function signIn(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $user = PanunoteUsers::where('email', $request->email)->first();
        if ($user === null || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['msg' => 'Incorrect Password.']);
        }

        Session::put('USER_ID', $user->user_id);

        return to_route('subjects');
    }

    public function signOut()
    {
        Session::flush();
        return to_route('/');
    }






}

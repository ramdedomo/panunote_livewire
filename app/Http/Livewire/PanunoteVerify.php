<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PanunoteUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\rand;
use DB;
use Redirect;
use Carbon\Carbon;
use Session;

class PanunoteVerify extends Component
{
    public $user;
    public $email;
    public $verification_code;

    public function mount(){
        $this->user = PanunoteUsers::where('user_id', Auth::user()->user_id)->first();
        $this->email =   $this->user->email;
    }

    public function verifycode(){

        $this->validate([
            'email' => 'required|email',
            'verification_code' => 'required|min:6',
        ]);

        $isexists = DB::table('email_verification')
        ->where('email', $this->email)
        ->where('status', 0)
        ->where('code', $this->verification_code)->exists();

        if($isexists){
            PanunoteUsers::where('user_id', Auth::user()->user_id)->update([
                'email' => $this->email,
                'isverified' => 1
            ]);

            DB::table('email_verification')
            ->where('email', $this->email)
            ->where('status', 0)
            ->where('code', $this->verification_code)->update([
                'status' => 1
            ]);

            DB::table('panunote_activity_logs')->insert([
                'user_id' => Auth::user()->user_id,
                'description' => "Account Verified",
                'created_at' => Carbon::now()
            ]);

            Session::put('user_email', $this->email);

            return redirect('subjects');
        }else{
            Session::flash('error', "Invalid Code.");
        }


    }

    public function sendcode(){

        $this->validate([
            'email' => 'required|email|exists:panunote_users,email,isverified,0',
        ],[
            'email.exists' => 'This :attribute is already Registered and Verified.'
        ]);

        $token = rand(000000000000,100000000000);
        DB::table('email_verification')->insert([
            'email' => $this->email,
            'code' => $token,
            'created_at' => Carbon::now(),
        ]);

        //$user = PanunoteUsers::where('email', $this->email)->first();

        //$link = route('reset', ['token'=>$token, 'email'=>$user->email]);

        $body_message = "<span class='font button-reset'>". $token ."</span>";

        $data = [
            'title' => 'Panunote Verify Email',
            'name' => 'Panunote User',
            'info' => 'To Verify Email please Input this Code:',
            'body' => $body_message,
        ];

        Mail::send('pages.panunote_email', $data, function ($message){
            $message->from('john@johndoe.com', 'Panunote: Online Study Companion');
            $message->to($this->email, 'Panunote User');
            $message->subject('Panunote Verify Email');
        });

        Session::flash('success', "Verification Code Sent! Please Check your Email.");
        $this->dispatchBrowserEvent('sentcode');
        return Redirect::back();
        

    }

    public function render()
    {
        return view('livewire.panunote-verify')->layout('layouts.verify');
    }
}

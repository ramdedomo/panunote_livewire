<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use Redirect;
use Session;
use App\Models\PanunoteUsers;
use Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ForgotPassword extends Component
{

    public $password;
    public $password_confirmation;
    public $email;
    public $token;

    protected $rules = [
        'password' => 'required|confirmed|min:6'
    ];

    public function resetpass(){
        $this->validate();

        $check = DB::table('password_resets')
        ->where('email', $this->email)
        ->where('token', $this->token)
        ->exists();

        if($check){

            PanunoteUsers::where('email', $this->email)->update([
                'password' => Hash::make($this->password)
            ]);

            DB::table('password_resets')
            ->where('email', $this->email)
            ->where('token', $this->token)
            ->update(['status' => 1]);

            

            DB::table('panunote_activity_logs')->insert([
                'user_id' => PanunoteUsers::where("email", $this->email)->first()->user_id,
                'description' => "Password Reset",
                'created_at' => Carbon::now()
            ]);
    

            Session::flash('success', "Your password has been Updated! Login to your Account.");
            return redirect('forgot');

        }else{
            Session::flash('error', "Invalid Token");
        }
    }

    public function mount(){
        $this->email = request()->email;
        $this->token = request()->token;
    }

    public function render()
    {
        $check = DB::table('password_resets')
        ->where('email', $this->email)
        ->where('token', $this->token)
        ->where('status', 0)
        ->exists();

        if($check){
            return view('livewire.forgot-password')->layout('layouts.reset');
        }else{
            abort(404);
        }

    }
}

<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PanunoteUsers;
use Session;
use Hash;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\rand;
use Redirect;
class PanunoteSettings extends Component
{
    use WithFileUploads;
    public $user_info;

    public $display_picture;

    public $user_fname;
    public $user_lname;
    public $email;
    public $username;

    public $oldpassword;
    public $newpassword;

    public $removephoto = false;

    public $verification_code;

    public function save()
    {

        if($this->removephoto){

            $a = PanunoteUsers::where('user_id', Auth::user()->user_id)
            ->update([
                'user_photo' =>  null,
            ]);

            if($a){
                $this->user_info->user_photo = null;
                Session::flash('successphoto', "Profile Updated!");
            }else{
                Session::flash('errorphoto', "Something went Wrong, Please try again");
            }
           
        }else{
            $this->validate([
                'display_picture' => 'image|max:1024', // 1MB Max
            ]);
                    
            $path = $this->display_picture->getRealPath();
            $logo = file_get_contents($path);
            $base64 = base64_encode($logo);
    
            $a = PanunoteUsers::where('user_id', Auth::user()->user_id)
            ->update([
                'user_photo' =>  $base64,
            ]);
    
            if($a){
                $this->user_info->user_photo = $base64;
                Session::flash('successphoto', "Profile Updated!");
            }else{
                Session::flash('errorphoto', "Something went Wrong, Please try again");
            }
        }

  

    }

    public function mount(){
        $this->user_info = PanunoteUsers::where('user_id', Auth::user()->user_id)->first();

        $this->user_fname = $this->user_info->user_fname;
        $this->user_lname = $this->user_info->user_lname;
        $this->email = $this->user_info->email;
        $this->username = $this->user_info->username;
    }

    public function verifycode(){
        $this->validate([
            'email' => 'required|email|unique:panunote_users,email,0,isverified',
            'verification_code' => 'required|min:6',
        ],[
            'email.unique' => 'This :attribute is already Registered and Verified.'
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

            Session::put('user_email', $this->email);

            $this->email = $this->email;
            Session::flash('success', "New Email Verified!");
        }else{
            Session::flash('error', "Invalid Code.");
        }

    }

    public function changeemail(){
        if($this->email == $this->user_info->email){
            Session::flash('error', "No Changes");
        }else{
            
            $this->validate([
                'email' => 'required|email|unique:panunote_users,email,0,isverified',
            ],[
                'email.unique' => 'This :attribute is already Registered and Verified.'
            ]);

            $token = rand(000000000000,100000000000);
            DB::table('email_verification')->insert([
                'email' => $this->email,
                'code' => $token,
                'created_at' => Carbon::now(),
            ]);
    
            $body_message = "<span class='font button-reset'>". $token ."</span>";
    
            $data = [
                'title' => 'Panunote Change Email',
                'name' => 'Panunote User',
                'info' => 'To Verify Email please Input this Code:',
                'body' => $body_message,
            ];
    
            Mail::send('pages.panunote_email', $data, function ($message){
                $message->from('john@johndoe.com', 'Panunote: Online Study Companion');
                $message->to($this->email, 'Panunote User');
                $message->subject('Panunote Verify Email');
            });

            Session::flash('success', "Verification Code Sent! Please Check your Email and Enter the code below.");
  
        }
    }

    public function password(){


        $validatedData = $this->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
        ]);

    
        
        if (Hash::check($this->oldpassword, $this->user_info->password)) {

            $a = PanunoteUsers::where('user_id', Auth::user()->user_id)
            ->update([
                'password' =>  Hash::make($this->newpassword),
            ]);
    
            if($a){
                Session::flash('success', "Password Updated!");
            }
           
        }else{
            Session::flash('error', "Wrong Password, Try Again");
        }


    }

    protected function rules()
    {
        return [
            'user_fname' => 'required',
            'user_lname' => 'required',
            //'email' => 'required|email|unique:panunote_users,email,'.$this->user_info->user_id.',user_id',
            'username' => 'required|min:6',
        ];
    }

    public function submit(){
        $this->validate();

        $a = PanunoteUsers::where('user_id', Auth::user()->user_id)
        ->update([
            'user_fname' =>  $this->user_fname,
            'user_lname' => $this->user_lname,
            'username' =>  $this->username,
        ]);

        if($a){
            Session::flash('successinfo', "Personal Info Updated!");
        }else{
            Session::flash('errorinfo', "Nice, No Changes");
        }

    }

    public function render()
    {
        
        return view('livewire.panunote-settings');
    }
}

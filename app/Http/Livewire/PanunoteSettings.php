<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PanunoteUsers;
use Session;
use Hash;
use Livewire\WithFileUploads;

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

    public function save()
    {

        if($this->removephoto){

            $a = PanunoteUsers::where('user_id', session('USER_ID'))
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
    
            $a = PanunoteUsers::where('user_id', session('USER_ID'))
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
        $this->user_info = PanunoteUsers::where('user_id', session('USER_ID'))->first();

        $this->user_fname = $this->user_info->user_fname;
        $this->user_lname = $this->user_info->user_lname;
        $this->email = $this->user_info->email;
        $this->username = $this->user_info->username;
    }

    public function password(){


        $validatedData = $this->validate([
            'oldpassword' => 'required',
            'newpassword' => 'required',
        ]);

    
        
        if (Hash::check($this->oldpassword, $this->user_info->password)) {

            $a = PanunoteUsers::where('user_id', session('USER_ID'))
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
            'email' => 'required|email|unique:panunote_users,email,'.$this->user_info->user_id.',user_id',
            'username' => 'required|min:6',
        ];
    }

    public function submit(){
        $this->validate();

        $a = PanunoteUsers::where('user_id', session('USER_ID'))
        ->update([
            'user_fname' =>  $this->user_fname,
            'user_lname' => $this->user_lname,
            'email' => $this->email,
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

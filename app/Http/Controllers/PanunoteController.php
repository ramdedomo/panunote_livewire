<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\PanunoteUsers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use DB;
use Redirect;

class PanunoteController extends Controller
{
    
    // public function userinfo(){
    //     if(Session::has('USER_FIREBASEID')){

    //         //get userid
    //         $userId = session('USER_FIREBASEID');
    //         //get user info
    //         $userInfo = app('firebase.firestore')->database()->collection('User')->document($userId)->snapshot();
    //         return $userInfo->data()['firstname'] . " " .  $userInfo->data()['lastname'];

    //     }else{
    //         return "No session";
    //     }
    // }

    // public function subjects(){
    //     $fullname = $this->userinfo();

    //     $subject = app('firebase.firestore')->database()->collection('Subjects');
    //     $query = $subject->where('uid', '=', session('USER_FIREBASEID'));
    //     $snapshot = $query->documents();

    //     $subject_list = array();
    //     foreach ($snapshot as $document) {
    //         $subject_list[] = app('firebase.firestore')->database()->collection('Subjects')->document($document->id())->snapshot();
    //     }

    //     return view('pages.panunote_subjects', ['name' => $fullname,  'subjects' => $subject_list]);
    // }

    public function recover(Request $request){

        $request->validate([
            'email' => 'required|email|exists:panunote_users,email',
        ],[
            'email.exists' => 'The :attribute is not registered.'
        ]);

        $token = base64_encode(Str::random(64));
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        $user = PanunoteUsers::where('email', $request->email)->first();

        $link = route('reset', ['token'=>$token, 'email'=>$user->email]);

        $body_message = "<a href='".$link."' class='font button-reset'>Reset Password</a>";

        $data = [
            'title' => 'Panunote Password Reset',
            'name' => $user->user_fname,
            'info' => 'To Reset the Password Click the button Below:',
            'body' => $body_message,
        ];

        Mail::send('pages.panunote_email', $data, function ($message) use ($user){
            $message->from('john@johndoe.com', 'Panunote: Online Study Companion');
            $message->to($user->email, $user->firstname);
            $message->subject('Panunote Reset Password');
        });

        Session::flash('success', "Password Reset Sent! Please Check your Email. If not found, Check Spam.");
        return Redirect::back();

    }


    public function subject($id){
        $subject_details = app('firebase.firestore')->database()->collection('Subjects')->document($id)->snapshot();

        $notes = app('firebase.firestore')->database()->collection('Subjects')->document($id)->collection('Notes');
        $query = $notes->where('uid', '=', session('USER_FIREBASEID'));
        $snapshot = $query->documents();

        if(session('USER_FIREBASEID') != $subject_details->data()['uid']){
            if($subject_details->data()['subject_sharing']){

                $notes = app('firebase.firestore')->database()->collection('Subjects')->document($id)->collection('Notes');
                $query = $notes->where('note_sharing', '=', true);
                $snapshot = $query->documents();

                $note_list = array();
                foreach ($snapshot as $document) {
                    $note_list[] = app('firebase.firestore')->database()->collection('Subjects')->document($id)->collection('Notes')->document($document->id())->snapshot();
                }

                return dd($note_list);
            
                //return view('pages.panunote_subject', ['name' => $fullname, 'notes' => $note_list, 'subject_details' => $subject_details]);

                //return "(Public) Read Only View";

            }else{
                return "(Private) Owner only";
            }
        }else{
            $note_list = array();
            foreach ($snapshot as $document) {
                $note_list[] = app('firebase.firestore')->database()->collection('Subjects')->document($id)->collection('Notes')->document($document->id())->snapshot();
            }
        
            return view('pages.panunote_subject', ['notes' => $note_list, 'subject_details' => $subject_details]);
        }

       
    }


    function note($subject_id, $note_id){

        $subject_details = app('firebase.firestore')->database()->collection('Subjects')->document($subject_id)->snapshot();
        $note_details = app('firebase.firestore')->database()->collection('Subjects')->document($subject_id)->collection('Notes')->document($note_id)->snapshot();
        
        if(session('USER_FIREBASEID') != $note_details->data()['uid']){
            if($note_details->data()['note_sharing']){
                return "(Public) Read Only View";
            }else{
                return "(Private) Owner only";
            }
        }else{
            return view('pages.panunote_note', ['subject_details' => $subject_details, 'note_details' => $note_details]);
        }
    }

    function quizzes(){
      
        return view('pages.panunote_quizzes', []);
    }

    function dictionary(){
      
        return view('pages.panunote_dictionary', []);
    }
    
    function login(){
        return view('pages.auth.panunote_login');
    }

    function forgot(){
        return view('pages.auth.panunote_forgot');
    }

    function register(){
        return view('pages.auth.panunote_register');
    }

    function test(){
        return view('pages.panunote_email');
    }
}

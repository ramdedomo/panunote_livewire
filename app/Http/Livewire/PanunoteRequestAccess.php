<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PanunoteNotes;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\SubjectAccess;
use App\Models\NoteAccess;
use App\Models\QuizAccess;

class PanunoteRequestAccess extends Component
{

    public $type;
    public $requestid;

    public $details;
    public $exists;

    public function mount($type, $id){

        $this->type = $type;
        $this->requestid = $id;

        switch ($type) {
            case 'subject':
                $this->details = PanunoteSubjects::find($id);

                
                if($this->details->subject_sharing == 1){
                    return redirect()->to('/subjects/'.$id);
                }

                $approved = SubjectAccess::where('user_id', Auth::user()->user_id)
                ->where('subject_id', $id)
                ->where('has_access', 1)
                ->exists();

                if($approved){
                    return redirect()->to('/subjects/'.$id);
                }


                if(is_null( $this->details)){
                    abort(404);
                } 
                
                $this->user = PanunoteUsers::find($this->details->user_id);

                $existsreq = SubjectAccess::where('user_id', Auth::user()->user_id)
                ->where('subject_id', $id)
                ->where('has_access', 0)
                ->exists();

                if($existsreq){
                    $this->exists = true;
                }else{
                    $this->exists = false;
                }
                
                # code...
                break;

            case 'note':

                $this->details = PanunoteNotes::find($id);
             
                if($this->details->note_sharing == 1){
                    return redirect()->to('/subjects/'.$this->details->subject_id.'/'.$id.'');
                }

                $approved = NoteAccess::where('user_id', Auth::user()->user_id)
                ->where('note_id', $id)
                ->where('has_access', 1)
                ->exists();

                if($approved){
                    return redirect()->to('/subjects/'.$this->details->subject_id.'/'.$id.'');
                }
   

                if(is_null( $this->details)){
                    abort(404);
                }
                $this->user = PanunoteUsers::find($this->details->user_id);

                
                $existsreq = NoteAccess::where('user_id', Auth::user()->user_id)
                ->where('note_id', $id)
                ->where('has_access', 0)
                ->exists();

                if($existsreq){
                    $this->exists = true;
                }else{
                    $this->exists = false;
                }
                
                break;

            case 'quiz':
                $this->details = PanunoteQuizzes::find($id);

                if($this->details->quiz_sharing == 1){
                    return redirect()->to('/quizzes/'.$id.'');
                }
                
                $approved = QuizAccess::where('user_id', Auth::user()->user_id)
                ->where('quiz_id', $id)
                ->where('has_access', 1)
                ->exists();

                if($approved){
                    return redirect()->to('/quizzes/'.$id.'');
                }


                if(is_null( $this->details)){
                    abort(404);
                }
                $this->user = PanunoteUsers::find($this->details->user_id);

                $existsreq = QuizAccess::where('user_id', Auth::user()->user_id)
                ->where('quiz_id', $id)
                ->where('has_access', 0)
                ->exists();

                if($existsreq){
                    $this->exists = true;
                }else{
                    $this->exists = false;
                }

                break;

            default:
                abort(404);
                break;
        }



    }

    public function request_access(){
        switch ($this->type) {
            case 'subject':
                SubjectAccess::create([
                    'subject_id' =>  $this->requestid,
                    'user_id' => Auth::user()->user_id,
                    'has_access' => 0,
                ]);
                
                break;

            case 'note':
                NoteAccess::create([
                    'note_id' =>  $this->requestid,
                    'user_id' => Auth::user()->user_id,
                    'has_access' => 0,
                ]);

                break;

            case 'quiz':
                QuizAccess::create([
                    'quiz_id' =>  $this->requestid,
                    'user_id' => Auth::user()->user_id,
                    'has_access' => 0,
                ]);
                
                break;

            default:
                abort(404);
                break;

        }

        $this->exists = true;

        
    }

    public function render()
    {
        return view('livewire.panunote-request-access')->layout('layouts.request');
    }
}

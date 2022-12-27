<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteNotes;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteQuestions;
use App\Models\PanunoteNoteLikes;
use App\Models\PanunoteUsers;
use App\Models\PanunoteNoteVisits;
use Carbon\Carbon;
use URL;

class PanunoteNotePublic extends Component
{
    public $notecontent;
    public $subject_id;
    public $note_id;
    public $notevalues;
    public $user_name;
    
    public function mount($user_name=null,$subject_id=null, $note_id=null)
	{
		$this->subject_id = $subject_id;
        $this->note_id = $note_id;

        $subject = PanunoteSubjects::where('subject_id', $this->subject_id)->first();
        $note_details = PanunoteNotes::where('note_id', $this->note_id)->first();

        if(!is_null($note_details) && !is_null($subject)){
            if(session('USER_ID') != $note_details->user_id){
                if($note_details->note_sharing == 1 && $subject->subject_sharing == 1 && !empty(session('USER_ID'))){
                    
                }elseif($note_details->note_sharing == 0 && $subject->subject_sharing == 1 && !empty(session('USER_ID'))){
                    dd("Private");
                }else{
                    abort(404);
                }
            }
        }else{
            abort(404);
        }


        //visits count
        //check if exists
        $isexists = PanunoteNoteVisits::where('note_id', $this->note_id)
        ->where('user_id', session('USER_ID'))
        ->exists();

        if($isexists){
            $updated = PanunoteNoteVisits::where('note_id', $this->note_id)
            ->where('user_id', session('USER_ID'))
            ->orderBy('created_at', 'desc')
            ->first('updated_at');

            if((Carbon::now())->gte(Carbon::parse($updated->updated_at)->addSeconds(60))){
                PanunoteNoteVisits::create([
                    'note_id' => $this->note_id,
                    'user_id' => session('USER_ID'),
                ]);
            }
        }else{
            PanunoteNoteVisits::create([
                'note_id' => $this->note_id,
                'user_id' => session('USER_ID'),
            ]);
        }



        $this->generated_quizzes = PanunoteQuizzes::where('note_id', $this->note_id)
        ->where('quiz_sharing', 1)
        ->get();

        $count = 0;
        foreach($this->generated_quizzes as $note){
            $this->generated_quizzes[$count]['items'] = PanunoteQuestions::where('quiz_id', $note->quiz_id)->count();
            $count++;
        }
 
        $this->notetitle = $note_details->note_title;
        $this->notecontent = $note_details->note_content;

        //sharing
        $this->sharing = ($note_details->note_sharing == 0) ? false : true;

        $this->urlsharing = URL::current();

        if($this->sharing == "true"){
          $this->urlsharing = $this->urlsharing;
        }else{
          $this->urlsharing = "";
        }

        //favorite
        $like = PanunoteNoteLikes::where([
            ['note_id', $this->note_id],
            ['user_id', session('USER_ID')]
        ])->first();

        $this->isfavorite = (!is_null($like) && $like->note_like == 1) ? true : false;
	}

    public function like(){
        $this->isfavorite = !$this->isfavorite;

        $isexist = PanunoteNoteLikes::where([
            ['note_id', $this->note_id],
            ['user_id', session('USER_ID')]
        ])->exists();

        if($isexist){
            //update
            PanunoteNoteLikes::where('note_id', $this->note_id)
            ->where('user_id', session('USER_ID'))
            ->update(['note_like' => ($this->isfavorite) ? 1 : 0]);

        }else{
            //create
            PanunoteNoteLikes::create([
                'note_id' => $this->note_id,
                'user_id' => session('USER_ID'),
                'note_like' => ($this->isfavorite) ? 1 : 0
            ]);
        }
    }

    public function render()
    {
        $subject = PanunoteSubjects::where('subject_id', $this->subject_id)->first();
        $note_details = PanunoteNotes::where('note_id', $this->note_id)->first();
        
        return view('livewire.public.panunote-note-public', ['subject_details' => $subject, 'note_details' => $note_details]);
    }
}

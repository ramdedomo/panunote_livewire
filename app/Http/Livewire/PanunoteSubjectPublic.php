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
use App\Models\PanunoteSubjectLikes;
use App\Models\PanunoteUsers;
use App\Models\PanunoteSubjectVisits;
use Carbon\Carbon;
use URL;
use Illuminate\Support\Facades\Auth;
class PanunoteSubjectPublic extends Component
{
    public $subject_id;
    public $user_name;

    public function mount($user_name=null, $subject_id=null){
        $this->subject_id = $subject_id;
        $this->user_name = $user_name;

        $subject = PanunoteSubjects::where('subject_id', $this->subject_id)->first();

        if(!is_null($subject)){
            if(Auth::user()->user_id != $subject->user_id){
                if($subject->subject_sharing == 1 && !empty(Auth::user()->user_id)){

                }elseif($subject->subject_sharing == 0 && !empty(Auth::user()->user_id)){
                    return dd('Private');
                }else{
                    abort(404);
                }
            }
        }else{
            abort(404);
        }

        //visits count
        //check if exists
        $isexists = PanunoteSubjectVisits::where('subject_id', $this->subject_id)
        ->where('user_id', Auth::user()->user_id)
        ->exists();

        if($isexists){
            $updated = PanunoteSubjectVisits::where('subject_id', $this->subject_id)
            ->where('user_id', Auth::user()->user_id)
            ->orderBy('created_at', 'desc')
            ->first('updated_at');

            if((Carbon::now())->gte(Carbon::parse($updated->updated_at)->addSeconds(60))){
                PanunoteSubjectVisits::create([
                    'subject_id' => $this->subject_id,
                    'user_id' => Auth::user()->user_id,
                ]);
            }
        }else{
            PanunoteSubjectVisits::create([
                'subject_id' => $this->subject_id,
                'user_id' => Auth::user()->user_id,
            ]);
        }


        $this->subjectname = $subject->subject_name;
        //sharing
        $this->sharing = ($subject->subject_sharing == 0) ? false : true;

        $this->urlsharing = URL::current();

        if($this->sharing == "true"){
          $this->urlsharing = $this->urlsharing;
        }else{
          $this->urlsharing = "";
        }

        //favorite
        $like = PanunoteSubjectLikes::where([
            ['subject_id', $this->subject_id],
            ['user_id', Auth::user()->user_id]
        ])->first();

        $this->isfavorite = (!is_null($like) && $like->subject_like == 1) ? true : false;
    }

    public function like(){
        $this->isfavorite = !$this->isfavorite;

        $isexist = PanunoteSubjectLikes::where([
            ['subject_id', $this->subject_id],
            ['user_id', Auth::user()->user_id]
        ])->exists();

        if($isexist){
            //update
            PanunoteSubjectLikes::where('subject_id', $this->subject_id)
            ->where('user_id', Auth::user()->user_id)
            ->update(['subject_like' => ($this->isfavorite) ? 1 : 0]);

        }else{
            //create
            PanunoteSubjectLikes::create([
                'subject_id' => $this->subject_id,
                'user_id' => Auth::user()->user_id,
                'subject_like' => ($this->isfavorite) ? 1 : 0
            ]);
        }
    }


    public function render()
    {
        $subject = PanunoteSubjects::where('subject_id', $this->subject_id)->first();

        $note_list = PanunoteNotes::where('subject_id', $this->subject_id)
            ->where('note_sharing', 1)
            ->get();

        return view('livewire.public.panunote-subject-public', ['notes' => $note_list, 'subject_details' => $subject]);
    }
}

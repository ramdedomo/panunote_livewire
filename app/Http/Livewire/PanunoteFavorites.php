<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PanunoteSubjectLikes;
use App\Models\PanunoteNoteLikes;
use App\Models\PanunoteQuizLikes;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteNotes;
use App\Models\PanunoteUsers;
use App\Models\PanunoteQuestions;
use Illuminate\Support\Facades\Auth;
class PanunoteFavorites extends Component
{

    public $isSubempty;
    public $likeSubjects;
    public $isNoteempty;
    public $likeNotes;

    public function mount(){
        //subject
        $this->isSubempty = true;
        $this->likeSubjects = PanunoteSubjectLikes::where('user_id', Auth::user()->user_id)
        ->where('subject_like', 1)
        ->get();

        $countSub = 0;
        foreach($this->likeSubjects as $likesub){
            $this->likeSubjects[$countSub]['subject_content'] = PanunoteSubjects::where('subject_id', $likesub->subject_id)
            ->where('subject_sharing', 1)
            ->get();

            if(!($this->likeSubjects[$countSub]['subject_content'])->isEmpty()){
                $this->isSubempty = false;
                $this->likeSubjects[$countSub]['subject_info'] = PanunoteUsers::where('user_id', $this->likeSubjects[$countSub]['subject_content'][0]->user_id)->get();
            
                $this->likeSubjects[$countSub]['subject_notes'] = PanunoteNotes::where('subject_id', $likesub->subject_id)
                ->where('note_sharing', 1)
                ->get('note_title');
            }else{
                unset($this->likeSubjects[$countSub]);
            }
            
            $countSub++;
        }

        //notes
        $this->isNoteempty = true;
        $this->likeNotes = PanunoteNoteLikes::where('user_id', Auth::user()->user_id)
        ->where('note_like', 1)
        ->get();

        $countNote = 0;
        foreach($this->likeNotes as $likenote){

            $this->likeNotes[$countNote]['note_content'] = PanunoteNotes::where('note_id', $likenote->note_id)
            ->where('note_sharing', 1)
            ->get();

            if(!($this->likeNotes[$countNote]['note_content'])->isEmpty()){
                $this->isNoteempty = false;
                $this->likeNotes[$countNote]['note_info'] = PanunoteUsers::where('user_id', $this->likeNotes[$countNote]['note_content'][0]->user_id)->get();
            }else{
                unset($this->likeNotes[$countNote]);
            }

            $countNote++;
        }


        //quizzes
        $this->isQuizempty = true;
        $this->likeQuizzes = PanunoteQuizLikes::where('user_id', Auth::user()->user_id)
        ->where('quiz_like', 1)
        ->get();

        $countQuiz = 0;
        foreach($this->likeQuizzes as $likequiz){

            $this->likeQuizzes[$countQuiz]['quiz_content'] = PanunoteQuizzes::where('quiz_id', $likequiz->quiz_id)
            ->where('quiz_sharing', 1)
            ->get();

            if(!($this->likeQuizzes[$countQuiz]['quiz_content'])->isEmpty()){
                $this->isQuizempty = false;
                $this->likeQuizzes[$countQuiz]['quiz_info'] = PanunoteUsers::where('user_id', $this->likeQuizzes[$countQuiz]['quiz_content'][0]->user_id)->get();
                $this->likeQuizzes[$countQuiz]['quiz_count'] = PanunoteQuestions::where('quiz_id', $this->likeQuizzes[$countQuiz]['quiz_content'][0]->quiz_id)->count();
            }else{
                unset($this->likeNotes[$countNote]);
            }

            $countQuiz++;
        }

    }

    public function render()
    {
        return view('livewire.panunote-favorites');
    }
}

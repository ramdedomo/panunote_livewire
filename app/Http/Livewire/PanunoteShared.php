<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteNotes;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteQuestions;
use Illuminate\Support\Facades\Auth;
class PanunoteShared extends Component
{
    public $sharedSubjects;
    public $sharedNotes;
    public $sharedQuizzes;

    public function mount(){
        //subjects
        $this->sharedSubjects = PanunoteSubjects::where('user_id',  Auth::user()->user_id)
        ->where('subject_sharing', 1)
        ->get();

        $subcount = 0;
        foreach($this->sharedSubjects as $subject){
            $this->sharedSubjects[$subcount]['notes'] = PanunoteNotes::where('subject_id',  $subject->subject_id)->get();
            $subcount++;
        }

        //notes
        $this->sharedNotes = PanunoteNotes::where('user_id',  Auth::user()->user_id)
        ->where('note_sharing', 1)
        ->get();


        //quiz
        $this->sharedQuizzes = PanunoteQuizzes::where('user_id',  Auth::user()->user_id)
        ->where('quiz_sharing', 1)
        ->get();

        $quizcount = 0;
        foreach($this->sharedQuizzes as $quiz){
            $this->sharedQuizzes[$quizcount]['quiz_count'] = PanunoteQuestions::where('quiz_id',  $quiz->quiz_id)->count();
            $quizcount++;
        }


    }

    public function render()
    {
        return view('livewire.panunote-shared');
    }
}

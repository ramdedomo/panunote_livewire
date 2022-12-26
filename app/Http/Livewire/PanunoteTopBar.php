<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteNotes;

class PanunoteTopBar extends Component
{

    public $searchglobal;

    public function render()
    {

        $this->subjects = PanunoteSubjects::search($this->searchglobal)
        ->where('user_id', session('USER_ID'))
        ->when(empty($this->searchglobal), function ($query) {
            $query->where('subject_id', 0);
        })
        ->limit(2)
        ->get();

        $this->notes = PanunoteNotes::search($this->searchglobal)
        ->where('user_id', session('USER_ID'))
        ->when(empty($this->searchglobal), function ($query) {
            $query->where('note_id', 0);
        })
        ->limit(2)
        ->get();

        $this->quizzes = PanunoteQuizzes::search($this->searchglobal)
        ->where('user_id', session('USER_ID'))
        ->when(empty($this->searchglobal), function ($query) {
            $query->where('quiz_id', 0);
        })
        ->limit(2)
        ->get();


        return view('livewire.panunote-top-bar');
    }
}

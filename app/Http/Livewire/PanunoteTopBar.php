<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteNotes;
use App\Models\PanunoteUsers;
use Illuminate\Support\Facades\Auth;
class PanunoteTopBar extends Component
{

    public $user;
    public $searchglobal;

    protected $listeners = ['getscreentime' => 'getscreentime'];

    public function mount(){
        $this->user = PanunoteUsers::where('user_id', session('user_id'))->first();
    }

    public function getscreentime($screentime){
        PanunoteUsers::where('user_id', session('user_id'))->update([
            'screentime_main' => $this->user->screentime_main += $screentime
        ]);
    }

    public function render()
    {

        $this->subjects = PanunoteSubjects::searchall($this->searchglobal)
        ->where('user_id', session('user_id'))
        ->when(empty($this->searchglobal), function ($query) {
            $query->where('subject_id', 0);
        })
        ->limit(2)
        ->get();

        $this->notes = PanunoteNotes::searchall($this->searchglobal)
        ->where('user_id', session('user_id'))
        ->when(empty($this->searchglobal), function ($query) {
            $query->where('note_id', 0);
        })
        ->limit(2)
        ->get();

        $this->quizzes = PanunoteQuizzes::searchall($this->searchglobal)
        ->where('user_id',  session('user_id'))
        ->when(empty($this->searchglobal), function ($query) {
            $query->where('quiz_id', 0);
        })
        ->limit(2)
        ->get();


        return view('livewire.panunote-top-bar');
    }
}

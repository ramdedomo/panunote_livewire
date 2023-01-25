<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\SubjectAccess;
use App\Models\NoteAccess;
use App\Models\QuizAccess;
use Livewire\WithPagination;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteNotes;
use App\Models\PanunoteQuizzes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
class PanunoteRequestAccessList extends Component
{


    public $search;
    public $date;
    public function noteaccess($id){
        if(NoteAccess::find($id)->has_access == 0){
            NoteAccess::find($id)->update(['has_access' => 1]);
        }else{
            NoteAccess::find($id)->update(['has_access' => 0]);
        }
    }

    public function subjectaccess($id){
        if(SubjectAccess::find($id)->has_access == 0){
            SubjectAccess::find($id)->update(['has_access' => 1]);
        }else{
            SubjectAccess::find($id)->update(['has_access' => 0]);
        }
    }


    public function quizaccess($id){
        if(QuizAccess::find($id)->has_access == 0){
            QuizAccess::find($id)->update(['has_access' => 1]);
        }else{
            QuizAccess::find($id)->update(['has_access' => 0]);
        }
    }
    
    
    public function render()
    {
        $this->subjects = PanunoteSubjects::where('user_id', Auth::user()->user_id)->select('subject_id')->get()->toArray();
        $this->notes = PanunoteNotes::where('user_id', Auth::user()->user_id)->select('note_id')->get()->toArray();
        $this->quizzes = PanunoteQuizzes::where('user_id', Auth::user()->user_id)->select('quiz_id')->get()->toArray();

        $this->subjects = array_column($this->subjects, 'subject_id');
        $this->notes = array_column($this->notes, 'note_id');
        $this->quizzes = array_column($this->quizzes, 'quiz_id');

        $subject_access = SubjectAccess::when(empty($this->search), function ($query) {
            $query->whereIn('panunote_subject_access.subject_id', $this->subjects);
        })
        ->when(!empty($this->search), function ($query) {
            $query->where('panunote_subjects.subject_name', 'like', '%'.$this->search.'%')
            ->orWhere('panunote_users.username', 'like', '%'.$this->search.'%');
        })
        ->join('panunote_users', 'panunote_subject_access.user_id', 'panunote_users.user_id')
        ->join('panunote_subjects', 'panunote_subject_access.subject_id', 'panunote_subjects.subject_id')
        ->when(!empty($this->date), function ($query) {
            $query->whereBetween('panunote_subject_access.created_at', [Carbon::parse($this->date)->startOfDay(), Carbon::parse($this->date)->endOfDay()]);
        })
        ->select('panunote_subjects.*','panunote_users.*','panunote_subject_access.*','panunote_subject_access.created_at AS requested_date')
        ->paginate(8, ['*'], 'subjects');
        
        
        $note_access = NoteAccess::when(empty($this->search), function ($query) {
            $query->whereIn('panunote_note_access.note_id', $this->notes);
        })
        ->when(!empty($this->search), function ($query) {
            $query->where('panunote_notes.note_title', 'like', '%'.$this->search.'%')
            ->orWhere('panunote_users.username', 'like', '%'.$this->search.'%');
        })
        ->when(!empty($this->date), function ($query) {
            $query->whereBetween('panunote_note_access.created_at', [Carbon::parse($this->date)->startOfDay(), Carbon::parse($this->date)->endOfDay()]);
        })
        ->join('panunote_users', 'panunote_note_access.user_id', 'panunote_users.user_id')
        ->join('panunote_notes', 'panunote_note_access.note_id', 'panunote_notes.note_id')
        ->select('panunote_notes.*','panunote_users.*','panunote_note_access.*','panunote_note_access.created_at AS requested_date')
        ->paginate(8, ['*'], 'notes');


        $quiz_access = QuizAccess::when(empty($this->search), function ($query) {
            $query->whereIn('panunote_quiz_access.quiz_id', $this->quizzes);
        })
        ->when(!empty($this->search), function ($query) {
            $query->where('panunote_quizzes.quiz_title', 'like', '%'.$this->search.'%')
            ->orWhere('panunote_users.username', 'like', '%'.$this->search.'%');
        })
        ->when(!empty($this->date), function ($query) {
            $query->whereBetween('panunote_quiz_access.created_at', [Carbon::parse($this->date)->startOfDay(), Carbon::parse($this->date)->endOfDay()]);
        })
        ->join('panunote_users', 'panunote_quiz_access.user_id', 'panunote_users.user_id')
        ->join('panunote_quizzes', 'panunote_quiz_access.quiz_id', 'panunote_quizzes.quiz_id')
        ->select('panunote_quizzes.*','panunote_users.*','panunote_quiz_access.*','panunote_quiz_access.created_at AS requested_date')
        ->paginate(8, ['*'], 'quizzes');



        return view('livewire.panunote-request-access-list', 
        [
            'subject_access' => $subject_access,
            'note_access' => $note_access,
            'quiz_access' => $quiz_access,
        ]);
    }
}

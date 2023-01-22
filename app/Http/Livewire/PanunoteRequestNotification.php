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

class PanunoteRequestNotification extends Component
{
    public function render()
    {

        $this->subjects = PanunoteSubjects::where('user_id', Auth::user()->user_id)->select('subject_id')->get()->toArray();
        $this->notes = PanunoteNotes::where('user_id', Auth::user()->user_id)->select('note_id')->get()->toArray();
        $this->quizzes = PanunoteQuizzes::where('user_id', Auth::user()->user_id)->select('quiz_id')->get()->toArray();

        $this->subjects = array_column($this->subjects, 'subject_id');
        $this->notes = array_column($this->notes, 'note_id');
        $this->quizzes = array_column($this->quizzes, 'quiz_id');

        $subject_access = SubjectAccess::whereIn('panunote_subject_access.subject_id', $this->subjects)
        ->join('panunote_users', 'panunote_subject_access.user_id', 'panunote_users.user_id')
        ->join('panunote_subjects', 'panunote_subject_access.subject_id', 'panunote_subjects.subject_id')
        ->orderBy('panunote_subject_access.created_at', 'DESC')
        ->limit(2)
        ->get();

        $note_access = NoteAccess::whereIn('panunote_note_access.note_id', $this->notes)
        ->join('panunote_users', 'panunote_note_access.user_id', 'panunote_users.user_id')
        ->join('panunote_notes', 'panunote_note_access.note_id', 'panunote_notes.note_id')
        ->orderBy('panunote_note_access.created_at', 'DESC')
        ->limit(2)
        ->get();

        $quiz_access = QuizAccess::whereIn('panunote_quiz_access.quiz_id', $this->quizzes)
        ->join('panunote_users', 'panunote_quiz_access.user_id', 'panunote_users.user_id')
        ->join('panunote_quizzes', 'panunote_quiz_access.quiz_id', 'panunote_quizzes.quiz_id')
        ->orderBy('panunote_quiz_access.created_at', 'DESC')
        ->limit(2)
        ->get();

        return view('livewire.panunote-request-notification',
        [
            'subject_access' => $subject_access,
            'note_access' => $note_access,
            'quiz_access' => $quiz_access,
        ]);
    }
}

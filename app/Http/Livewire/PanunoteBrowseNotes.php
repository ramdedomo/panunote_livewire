<?php

namespace App\Http\Livewire;

use App\Models\PanunoteUsers;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteNotes;
use App\Models\PanunoteNoteVisits;
use App\Models\PanunoteNoteLikes;

class PanunoteBrowseNotes extends Component
{
    public $startDate;
    public $endDate;

    public $weekly = false;
    public $monthly = true;
    public $yearly = false;

    public $note_topvisits;
    public $note_toplikes;

    public $isnotevisitempty = false;
    public $isnotelikeempty = false;

    public $note_visits_count;
    public $note_likes_count;

    public $subjects;
    public $notes;
    public $quizzes;
    public $search;
    

    public function visit($note_id, $subject_id){
        return redirect('subjects/'.$subject_id.'/'.$note_id);
    }

    public function changedate($start, $end){

        $this->reset([
            'note_visits_count',
            'note_likes_count',
            'note_topvisits',
            'note_toplikes'
        ]);

        $note_visits_all = PanunoteNoteVisits::whereBetween('created_at', [$start, $end])->get();
        $note_likes_all = PanunoteNoteLikes::where('note_like', 1)->whereBetween('created_at', [$start, $end])->get();

        // ************************ notes ***************************


        if (!$note_visits_all->isEmpty()) {
            //make all count to 0
            foreach($note_visits_all as $note){
                $this->note_visits_count[$note->note_id] = 0;
            }
                 
            //increment the zero
            foreach($note_visits_all as $note){
                $this->note_visits_count[$note->note_id]++;
            }

            arsort($this->note_visits_count);

            //get subjects sorted
            $count = 0;
            foreach($this->note_visits_count as $visit_note_key => $visit_note_count){
                $note_visit_info = PanunoteNotes::select('note_id','subject_id', 'note_title', 'user_id')->where('note_id', $visit_note_key)->first();
                if($note_like_info->note_sharing == 1){
                    $this->note_topvisits[$count] = $note_visit_info;
                    $this->note_topvisits[$count]['user_info'] = PanunoteUsers::where('user_id', $note_visit_info->user_id)->get();
                    $this->note_topvisits[$count]['visit_count'] = $visit_note_count;
                    $count++;
                }
            }

            $this->isnotevisitempty = false;
        }else{
            $this->note_topvisits = [];
            $this->isnotevisitempty = true;
        }

        if (!$note_likes_all->isEmpty()) {
            //make all count to 0
            foreach($note_likes_all as $note){
                $this->note_likes_count[$note->note_id] = 0;
            }
                 
            //increment the zero
            foreach($note_likes_all as $note){
                $this->note_likes_count[$note->note_id]++;
            }

            arsort($this->note_likes_count);

            //get subjects sorted
            $count = 0;
            foreach($this->note_likes_count as $like_note_key => $like_note_count){
                $note_like_info = PanunoteNotes::select('note_id','subject_id', 'note_title', 'user_id')->where('note_id', $like_note_key)->first();
                if($note_like_info->note_sharing == 1){
                    $this->note_toplikes[$count] = $note_like_info;
                    $this->note_toplikes[$count]['user_info'] = PanunoteUsers::where('user_id', $note_like_info->user_id)->get();
                    $this->note_toplikes[$count]['like_count'] = $like_note_count;
                    $count++;
                }

            }

            $this->isnotelikeempty = false;
        }else{
            $this->note_toplikes = [];
            $this->isnotelikeempty = true;
        }

        
 
        $this->dispatchBrowserEvent('contentChanged');
    }

    public function topsubjects($date){
        if($date == 'weekly'){

            $this->startDate = Carbon::now()->subDays(7)->startOfDay()->format('Y-m-d');
            $this->endDate = Carbon::now()->endOfDay()->format('Y-m-d');
      
            $this->weekly = true;
            $this->monthly = false;
            $this->yearly = false;

            $this->changedate($this->startDate, $this->endDate);


        }elseif($date == 'monthly'){

            $this->startDate = Carbon::now()->subDays(31)->startOfDay()->format('Y-m-d');
            $this->endDate = Carbon::now()->endOfDay()->format('Y-m-d');

            $this->weekly = false;
            $this->monthly = true;
            $this->yearly = false;
            
            $this->changedate($this->startDate, $this->endDate);
       

        }elseif($date == 'yearly'){

            $this->startDate = Carbon::now()->subDays(365)->startOfDay()->format('Y-m-d');
            $this->endDate = Carbon::now()->endOfDay()->format('Y-m-d');

            $this->weekly = false;
            $this->monthly = false;
            $this->yearly = true;
            
            $this->changedate($this->startDate, $this->endDate);
          
        }


    }

    public function mount(){
        //month

        //dd($subject_visits_count, $subject_likes_count);
        //dd($subject_likes_count, $subject_visits_count, $subject_likes_all, $subject_visits_all);
    }

    public function render()
    {
        $this->startDate = Carbon::now()->subDays(31)->startOfDay()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfDay()->format('Y-m-d');
        $this->changedate($this->startDate, $this->endDate);

        $this->subjects = PanunoteSubjects::search($this->search)
        ->join('panunote_users', 'panunote_users.user_id', '=', 'panunote_subjects.user_id')
        ->when(empty($this->search), function ($query) {
            $query->where('subject_id', 0);
        })
        ->select('panunote_users.user_id','panunote_users.username', 'panunote_subjects.subject_name', 'panunote_subjects.subject_id')
        ->get();

        $this->notes = PanunoteNotes::search($this->search)
        ->join('panunote_users', 'panunote_users.user_id', '=', 'panunote_notes.user_id')
        ->join('panunote_subjects', function ($join) {
            $join->on('panunote_notes.subject_id', '=', 'panunote_subjects.subject_id')
                 ->where('panunote_subjects.subject_sharing', '=', 1);
        })
        ->where('panunote_subjects.subject_sharing', 1)
        ->when(empty($this->search), function ($query) {
            $query->where('note_id', 0);
        })
        ->select('panunote_users.username', 'panunote_notes.note_title', 'panunote_notes.user_id', 'panunote_notes.note_tags', 'panunote_notes.note_id', 'panunote_notes.subject_id')
        ->get();

        $this->quizzes = PanunoteQuizzes::search($this->search)
        ->join('panunote_users', 'panunote_users.user_id', '=', 'panunote_quizzes.user_id')
        ->when(empty($this->search), function ($query) {
            $query->where('quiz_id', 0);
        })
        ->select('panunote_users.username', 'panunote_quizzes.quiz_title', 'panunote_quizzes.user_id', 'panunote_quizzes.quiz_tags', 'panunote_quizzes.quiz_id')
        ->get();

        return view('livewire.panunote-browse-notes');
    }
}

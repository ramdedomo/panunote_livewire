<?php

namespace App\Http\Livewire;

use App\Http\Livewire\PanunoteQuizzes as LivewirePanunoteQuizzes;
use App\Models\PanunoteSubjectLikes;
use App\Models\PanunoteUsers;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteNotes;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\PanunoteSubjectVisits;

class PanunoteBrowseSubject extends Component
{
    public $startDate;
    public $endDate;

    public $weekly = false;
    public $monthly = true;
    public $yearly = false;

    public $toplikes;
    public $topvisits;
    
    public $isvisitempty = false;
    public $islikeempty = false;

    public $subject_likes_count;
    public $subject_visits_count;

    
    public $subjects;
    public $notes;
    public $quizzes;
    public $search;


    public function visit($subject_id){
        return redirect('subjects/'.$subject_id);
    }

    public function changedate($start, $end){

        $this->reset([
            'subject_visits_count',
            'subject_likes_count',
            'topvisits',
            'toplikes'
        ]);

        $subject_visits_all = PanunoteSubjectVisits::whereBetween('created_at', [$start, $end])->get();
        $subject_likes_all = PanunoteSubjectLikes::where('subject_like', 1)->whereBetween('created_at', [$start, $end])->get();

       // ************************ subjects ***************************

        if (!$subject_visits_all->isEmpty()) {
            //make all count to 0
            foreach($subject_visits_all as $sub){
                $this->subject_visits_count[$sub->subject_id] = 0;
            }
                 
            //increment the zero
            foreach($subject_visits_all as $sub){
                $this->subject_visits_count[$sub->subject_id]++;
            }

            arsort($this->subject_visits_count);

            //get subjects sorted
            $count = 0;
            foreach($this->subject_visits_count as $visit_sub_key => $visit_sub_count){
                $subject_visit_info = PanunoteSubjects::where('subject_id', $visit_sub_key)->first();
                if($subject_visit_info->subject_sharing == 1){
                    $this->topvisits[$count] = $subject_visit_info;
                    $this->topvisits[$count]['user_info'] = PanunoteUsers::where('user_id', $subject_visit_info->user_id)->get();
                    $this->topvisits[$count]['visit_count'] = $visit_sub_count;
                    $count++;
                }

            }

            if(empty($this->topvisits)){
                $this->isvisitempty = true;
            }else{
                $this->isvisitempty = false;
            }

        }else{
            $this->topvisits = [];
            $this->isvisitempty = true;
        }

        if (!$subject_likes_all->isEmpty()) {
            foreach($subject_likes_all as $sub){
                $this->subject_likes_count[$sub->subject_id] = 0;
            }

            foreach($subject_likes_all as $sub){
                $this->subject_likes_count[$sub->subject_id]++;
            }

            //sort desc
            arsort($this->subject_likes_count);

            $count = 0;
            foreach($this->subject_likes_count as $like_sub_key => $like_sub_count){
                $subject_like_info = PanunoteSubjects::where('subject_id', $like_sub_key)->first();
                if($subject_like_info->subject_sharing == 1){
                    $this->toplikes[$count] = $subject_like_info;
                    $this->toplikes[$count]['user_info'] = PanunoteUsers::where('user_id', $subject_like_info->user_id)->get();
                    $this->toplikes[$count]['like_count'] = $like_sub_count;
                    $count++;
                }
            }


            if(empty($this->toplikes)){
                $this->islikeempty = true;
            }else{
                $this->islikeempty = false;
            }
      
        }else{
            $this->toplikes = [];
            $this->islikeempty = true;
        }

        $this->dispatchBrowserEvent('contentChanged');
    }

    public function topsubjects($date){
        if($date == 'weekly'){

            $this->startDate = Carbon::now()->subDays(7)->startOfDay()->format('Y-m-d');
            $this->endDate = Carbon::now()->addDays(1)->format('Y-m-d');

            $this->weekly = true;
            $this->monthly = false;
            $this->yearly = false;

            $this->changedate($this->startDate, $this->endDate);


        }elseif($date == 'monthly'){

            $this->startDate = Carbon::now()->subDays(31)->startOfDay()->format('Y-m-d');
            $this->endDate = Carbon::now()->addDays(1)->format('Y-m-d');

            $this->weekly = false;
            $this->monthly = true;
            $this->yearly = false;
            
            $this->changedate($this->startDate, $this->endDate);
       

        }elseif($date == 'yearly'){

            $this->startDate = Carbon::now()->subDays(365)->startOfDay()->format('Y-m-d');
            $this->endDate = Carbon::now()->addDays(1)->format('Y-m-d');

            $this->weekly = false;
            $this->monthly = false;
            $this->yearly = true;
            
            $this->changedate($this->startDate, $this->endDate);
          
        }


    }

    public function mount(){
    }


    public function render()
    {
        $this->startDate = Carbon::now()->subDays(31)->startOfDay()->format('Y-m-d');
        $this->endDate = Carbon::now()->addDays(1)->format('Y-m-d');
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

        return view('livewire.panunote-browse-subject', ['subjects' => $this->subjects]);
    }
}

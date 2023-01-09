<?php

namespace App\Http\Livewire;

use App\Models\PanunoteUsers;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\PanunoteQuizLikes;
use App\Models\PanunoteQuizVisits;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteNotes;
use Illuminate\Support\Facades\Auth;
class PanunoteBrowseQuizzes extends Component
{
    public $startDate;
    public $endDate;

    public $weekly = false;
    public $monthly = true;
    public $yearly = false;

    public $quiz_topvisits;
    public $quiz_toplikes;
    
    public $isquizvisitempty = false;
    public $isquizlikeempty = false;
    
    public $quiz_visits_count;
    public $quiz_likes_count;

    public $subjects;
    public $notes;
    public $quizzes;
    public $search;

    public function visit($quiz_id){
        return redirect('quizzes/'.$quiz_id);
    }

    public function changedate($start, $end){

        $this->reset([
            'quiz_visits_count',
            'quiz_likes_count',
            'quiz_topvisits',
            'quiz_toplikes'
        ]);

        $quiz_visits_all = PanunoteQuizVisits::whereBetween('created_at', [$start, $end])->get();
        $quiz_likes_all = PanunoteQuizLikes::where('quiz_like', 1)->whereBetween('created_at', [$start, $end])->get();

        // ************************ quizzes ***************************

        if (!$quiz_visits_all->isEmpty()) {
            //make all count to 0
            foreach($quiz_visits_all as $quiz){
                $this->quiz_visits_count[$quiz->quiz_id] = 0;
            }
                 
            //increment the zero
            foreach($quiz_visits_all as $quiz){
                $this->quiz_visits_count[$quiz->quiz_id]++;
            }

            arsort($this->quiz_visits_count);

            //get subjects sorted
            $count = 0;
            foreach($this->quiz_visits_count as $visit_quiz_key => $visit_quiz_count){
                $quiz_visit_info = PanunoteQuizzes::where('quiz_id', $visit_quiz_key)->first();
                if($quiz_visit_info->quiz_sharing == 1){
                    $this->quiz_topvisits[$count] = $quiz_visit_info;
                    $this->quiz_topvisits[$count]['user_info'] = PanunoteUsers::where('user_id', $quiz_visit_info->user_id)->get();
                    $this->quiz_topvisits[$count]['visit_count'] = $visit_quiz_count;
                    $count++;
                }
            }

            if(empty($this->quiz_topvisits)){
                $this->isquizvisitempty = true;
            }else{
                $this->isquizvisitempty = false;
            }

        }else{
            $this->quiz_topvisits = [];
            $this->isquizvisitempty = true;
        }



        if (!$quiz_likes_all->isEmpty()) {
            //make all count to 0
            foreach($quiz_likes_all as $quiz){
                $this->quiz_likes_count[$quiz->quiz_id] = 0;
            }
                 
            //increment the zero
            foreach($quiz_likes_all as $quiz){
                $this->quiz_likes_count[$quiz->quiz_id]++;
            }

            arsort($this->quiz_likes_count);

            //get subjects sorted
            $count = 0;
            foreach($this->quiz_likes_count as $like_quiz_key => $like_quiz_count){
                $quiz_like_info = PanunoteQuizzes::where('quiz_id', $like_quiz_key)->first();
                if($quiz_like_info->quiz_sharing == 1){
                    $this->quiz_toplikes[$count] = $quiz_like_info;
                    $this->quiz_toplikes[$count]['user_info'] = PanunoteUsers::where('user_id', $quiz_like_info->user_id)->get();
                    $this->quiz_toplikes[$count]['like_count'] = $like_quiz_count;
                    $count++;
                }
            }

            if(empty($this->quiz_toplikes)){
                $this->isquizlikeempty = true;
            }else{
                $this->isquizlikeempty = false;
            }

        }else{
            $this->quiz_toplikes = [];
            $this->isquizlikeempty = true;
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
        //month


        //dd($subject_visits_count, $subject_likes_count);
        //dd($subject_likes_count, $subject_visits_count, $subject_likes_all, $subject_visits_all);
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


        return view('livewire.panunote-browse-quizzes');
    }
}

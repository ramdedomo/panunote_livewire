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
use App\Models\PanunoteSubjectVisits;
use App\Models\PanunoteSubjectLikes;
use App\Models\PanunoteQuizLikes;
use App\Models\PanunoteQuizVisits;
use Illuminate\Support\Facades\Auth;
class PanunoteBrowseNotes extends Component
{
    public $startDate;
    public $endDate;

    public $weekly = false;
    public $monthly = true;
    public $yearly = false;

    public $toplikes;
    public $topvisits;
    public $note_topvisits;
    public $note_toplikes;
    public $quiz_topvisits;
    public $quiz_toplikes;

    public $isvisitempty = false;
    public $islikeempty = false;
    public $isnotevisitempty = false;
    public $isnotelikeempty = false;
    public $isquizvisitempty = false;
    public $isquizlikeempty = false;

    public $subject_likes_count;
    public $subject_visits_count;
    public $note_visits_count;
    public $note_likes_count;
    public $quiz_visits_count;
    public $quiz_likes_count;

    public $subjects;
    public $notes;
    public $quizzes;
    public $search;
    

    public function visit($note_id, $subject_id){
        return redirect('subjects/'.$subject_id.'/'.$note_id);
    }


    public function changedate($start, $end){
        //$this->dispatchBrowserEvent('contentChanged');
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
        $this->startDate = Carbon::now()->subDays(31)->startOfDay()->format('Y-m-d');
        $this->endDate = Carbon::now()->addDays(1)->format('Y-m-d');
        //dd($subject_visits_count, $subject_likes_count);
        //dd($subject_likes_count, $subject_visits_count, $subject_likes_all, $subject_visits_all);
    }

    public function render()
    {

        //$this->changedate($this->startDate, $this->endDate);

        $this->reset([
            'subject_visits_count',
            'subject_likes_count',
            'topvisits',
            'toplikes',
            'note_visits_count',
            'note_likes_count',
            'note_topvisits',
            'note_toplikes',
            'quiz_visits_count',
            'quiz_likes_count',
            'quiz_topvisits',
            'quiz_toplikes'
        ]);

        $subject_visits_all = PanunoteSubjectVisits::whereBetween('created_at', [$this->startDate , $this->endDate])->get();
        $subject_likes_all = PanunoteSubjectLikes::where('subject_like', 1)->whereBetween('created_at', [$this->startDate , $this->endDate])->get();
     
        $note_visits_all = PanunoteNoteVisits::whereBetween('created_at', [$this->startDate , $this->endDate])->get();
        $note_likes_all = PanunoteNoteLikes::where('note_like', 1)->whereBetween('created_at', [$this->startDate , $this->endDate])->get();

        $quiz_visits_all = PanunoteQuizVisits::whereBetween('created_at', [$this->startDate , $this->endDate])->get();
        $quiz_likes_all = PanunoteQuizLikes::where('quiz_like', 1)->whereBetween('created_at', [$this->startDate , $this->endDate])->get();

        
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
                if($count < 4){
                    $subject_visit_info = PanunoteSubjects::where('subject_id', $visit_sub_key)->first();
                    if($subject_visit_info->subject_sharing == 1){
                        $this->topvisits[$count] = $subject_visit_info;
                        $this->topvisits[$count]['user_info'] = PanunoteUsers::where('user_id', $subject_visit_info->user_id)->get();
                        $this->topvisits[$count]['visit_count'] = $visit_sub_count;
                        $count++;
                    }
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
                if($count < 4){
                    $subject_like_info = PanunoteSubjects::where('subject_id', $like_sub_key)->first();
                    if($subject_like_info->subject_sharing == 1){
                        $this->toplikes[$count] = $subject_like_info;
                        $this->toplikes[$count]['user_info'] = PanunoteUsers::where('user_id', $subject_like_info->user_id)->get();
                        $this->toplikes[$count]['like_count'] = $like_sub_count;
                        $count++;
                    }
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
                if($count < 4){
                    $note_visit_info = PanunoteNotes::join('panunote_subjects', 'panunote_notes.subject_id', '=', 'panunote_subjects.subject_id')
                    ->select('panunote_notes.note_content', 'panunote_notes.updated_at', 'panunote_notes.note_id','panunote_notes.subject_id', 'panunote_notes.note_title', 'panunote_notes.user_id', 'panunote_notes.note_sharing', 'panunote_subjects.subject_sharing')
                    ->where('note_id', $visit_note_key)
                    ->first();
                    if($note_visit_info->note_sharing == 1 && $note_visit_info->subject_sharing == 1){
                        $this->note_topvisits[$count] = $note_visit_info;
                        $this->note_topvisits[$count]['user_info'] = PanunoteUsers::where('user_id', $note_visit_info->user_id)->get();
                        $this->note_topvisits[$count]['visit_count'] = $visit_note_count;
                        $count++;
                    }
                }
            }

            if(empty($this->note_topvisits)){
                $this->isnotevisitempty = true;
            }else{
                $this->isnotevisitempty = false;
            }
        
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
                if($count < 4){
                    $note_like_info = PanunoteNotes::join('panunote_subjects', 'panunote_notes.subject_id', '=', 'panunote_subjects.subject_id')
                    ->select('panunote_notes.note_content', 'panunote_notes.updated_at', 'panunote_notes.note_id','panunote_notes.subject_id', 'panunote_notes.note_title', 'panunote_notes.user_id', 'panunote_notes.note_sharing', 'panunote_subjects.subject_sharing')
                    ->where('note_id', $like_note_key)
                    ->first();
                    
                    if($note_like_info->note_sharing == 1 && $note_like_info->subject_sharing == 1){
                        $this->note_toplikes[$count] = $note_like_info;
                        $this->note_toplikes[$count]['user_info'] = PanunoteUsers::where('user_id', $note_like_info->user_id)->get();
                        $this->note_toplikes[$count]['like_count'] = $like_note_count;
                        $count++;
                    }
                }
            }

            if(empty($this->note_toplikes)){
                $this->isnotelikeempty = true;
            }else{
                $this->isnotelikeempty = false;
            }

        }else{
            $this->note_toplikes = [];
            $this->isnotelikeempty = true;
        }


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
                if($count < 4){
                    $quiz_visit_info = PanunoteQuizzes::where('quiz_id', $visit_quiz_key)->first();
                    if($quiz_visit_info->quiz_sharing == 1){
                        $this->quiz_topvisits[$count] = $quiz_visit_info;
                        $this->quiz_topvisits[$count]['user_info'] = PanunoteUsers::where('user_id', $quiz_visit_info->user_id)->get();
                        $this->quiz_topvisits[$count]['visit_count'] = $visit_quiz_count;
                        $count++;
                    }
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
                if($count < 4){
                    $quiz_like_info = PanunoteQuizzes::where('quiz_id', $like_quiz_key)->first();
                    if($quiz_like_info->quiz_sharing == 1){
                        $this->quiz_toplikes[$count] = $quiz_like_info;
                        $this->quiz_toplikes[$count]['user_info'] = PanunoteUsers::where('user_id', $quiz_like_info->user_id)->get();
                        $this->quiz_toplikes[$count]['like_count'] = $like_quiz_count;
                        $count++;
                    }
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

<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\PanunoteNoteVisits;
use App\Models\PanunoteSubjectVisits;
use App\Models\PanunoteQuizVisits;
use App\Models\PanunoteNoteLikes;
use App\Models\PanunoteSubjectLikes;
use App\Models\PanunoteQuizLikes;
use App\Models\PanunoteQuizTakes;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteNotes;
use App\Models\PanunoteQuizzes;
use Carbon\Carbon;
use Livewire\WithPagination;

class PanunoteAnalytics extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
 
    public $subjects_all;

    public $subjects;
    public $notes;
    public $quizzes;

    public $subject_likes = [];
    public $subject_visits = [];
    
    public $note_likes = [];
    public $note_visits = [];

    public $quiz_likes = [];
    public $quiz_visits = [];

    public $subject_like_datasets = [];
    public $note_like_datasets = [];
    public $quiz_like_datasets = [];
    
    public $psubject_visits;
    public $pnote_visits;
    public $pquiz_visits;
    public $pquiz_takes;
    
    public $startDate;
    public $endDate;

    public $alltime = true;

    public $start_date;
    public $end_date;

    public function mount(){
        $this->start_date = Carbon::now()->format('Y-m-d');
        $this->end_date = Carbon::now()->addDay(31)->format('Y-m-d');
    }

    public function find(){

        $this->startDate = Carbon::createFromFormat('Y-m-d', $this->start_date)->startOfDay();
        $this->endDate = Carbon::createFromFormat('Y-m-d', $this->end_date)->endOfDay();
        // $posts = PanunoteSubjectVisits::whereBetween('created_at', [$startDate, $endDate])->count();

        // $this->quiz_visits[0] = ['x' => 'qweqweqwe', 'y' => 345345345];
        // $this->quiz_visits[1] = ['x' => '34', 'y' => 2343545];
        $this->psubject_visits = [];
        $this->pnote_visits = [];
        $this->pquiz_visits = [];
        $this->pquiz_takes = [];

          //subjects 
          $psubject_visits_all = PanunoteSubjectVisits::where('user_id', session('USER_ID'))
          ->whereBetween('created_at', [$this->startDate, $this->endDate])
          ->limit(3)->get();
          $ids = [];
  
          foreach($psubject_visits_all as $psubject_visit){
              $ids[$psubject_visit->subject_id] = $psubject_visit->subject_id;
          }
  
          foreach($ids as $id){
              $this->psubject_visits[$id]['subject_count'] = PanunoteSubjectVisits::where('subject_id', $id)
              ->where('user_id', session('USER_ID'))
              ->whereBetween('created_at', [$this->startDate, $this->endDate])
              ->count();

              $this->psubject_visits[$id]['subject_name'] = PanunoteSubjects::select('subject_id', 'subject_name')->where('subject_id', $id)->first()->subject_name;
          }
  
          usort($this->psubject_visits, function ($item1, $item2) {
              return $item2['subject_count'] <=> $item1['subject_count'];
          });
  
          //notes
  
          $pnote_visits_all = PanunoteNoteVisits::where('user_id', session('USER_ID'))
          ->whereBetween('created_at', [$this->startDate, $this->endDate])
          ->limit(3)->get();
          $ids = [];
  
          foreach($pnote_visits_all as $pnote_visit){
              $ids[$pnote_visit->note_id] = $pnote_visit->note_id;
          }
  
          foreach($ids as $id){
              $this->pnote_visits[$id]['note_count'] = PanunoteNoteVisits::where('note_id', $id)
              ->whereBetween('created_at', [$this->startDate, $this->endDate])
              ->where('user_id', session('USER_ID'))
              ->count();

              $this->pnote_visits[$id]['note_title'] = PanunoteNotes::select('note_id', 'note_title')->where('note_id', $id)->first()->note_title;
          }
  
          usort($this->pnote_visits, function ($item1, $item2) {
              return $item2['note_count'] <=> $item1['note_count'];
          });
          
          //quizzes
  
          $pquiz_visits_all = PanunoteQuizVisits::where('user_id', session('USER_ID'))
          ->whereBetween('created_at', [$this->startDate, $this->endDate])
          ->limit(3)->get();

          $ids = [];
  
          foreach($pquiz_visits_all as $pquiz_visit){
              $ids[$pquiz_visit->quiz_id] = $pquiz_visit->quiz_id;
          }
  
          foreach($ids as $id){
              $this->pquiz_visits[$id]['quiz_count'] = PanunoteQuizVisits::where('quiz_id', $id)
              ->whereBetween('created_at', [$this->startDate, $this->endDate])
              ->where('user_id', session('USER_ID'))
              ->count();

              $this->pquiz_visits[$id]['quiz_title'] = PanunoteQuizzes::select('quiz_title')->where('quiz_id', $id)->first()->quiz_title;
          }
  
          
          usort($this->pquiz_visits, function ($item1, $item2) {
              return $item2['quiz_count'] <=> $item1['quiz_count'];
          });
  
  
          //quizzes takes
  
          $pquiz_takes_all = PanunoteQuizTakes::where('user_id', session('USER_ID'))
          ->whereBetween('created_at', [$this->startDate, $this->endDate])
          ->limit(3)->get();

          $ids = [];
  
          foreach($pquiz_takes_all as $pquiz_take){
              $ids[$pquiz_take->quiz_id] = $pquiz_take->quiz_id;
          }
  
          foreach($ids as $id){
              $this->pquiz_takes[$id]['quiz_title'] = PanunoteQuizzes::select('quiz_title')->where('quiz_id', $id)->first()->quiz_title;
              $this->pquiz_takes[$id]['quiz_average'] = PanunoteQuizTakes::where('quiz_id', $id)
              ->whereBetween('created_at', [$this->startDate, $this->endDate])
              ->where('user_id', session('USER_ID'))
              ->avg('user_average');
          }
  
          usort($this->pquiz_takes, function ($item1, $item2) {
              return $item2['quiz_average'] <=> $item1['quiz_average'];
          });
  
          $this->subject_visits = [];
          $this->subject_likes = [];

          $this->note_visits = [];
          $this->note_likes = [];

          $this->quiz_visits = [];
          $this->quiz_likes = [];
  
          // $this->startDate = Carbon::createFromFormat('Y-m-d', '2022-12-01')->startOfDay();
          // $this->endDate = Carbon::createFromFormat('Y-m-d', '2022-12-30')->endOfDay();
          // $posts = PanunoteSubjectVisits::whereBetween('created_at', [$startDate, $endDate])->count();
          
          $this->subjects = PanunoteSubjects::select('subject_id', 'subject_name')
          ->where('user_id', session('USER_ID'))->get();
  
          $count = 0;
          foreach($this->subjects as $subject){
              $subjectlikes = PanunoteSubjectLikes::where('subject_id', $subject->subject_id)
              ->whereBetween('created_at', [$this->startDate, $this->endDate])
              ->where('subject_like', 1)->count();
              $subjectvisits = PanunoteSubjectVisits::where('subject_id', $subject->subject_id)
              ->whereBetween('created_at', [$this->startDate, $this->endDate])
              ->count();
              
              $this->subjects[$count]['subject_likes'] = $subjectlikes;
              $this->subjects[$count]['subject_visits'] = $subjectvisits;
  
              $this->subject_visits[$count] = ['x' => $subject->subject_name, 'y' => $subjectvisits];
              $this->subject_likes[$count] = ['x' => $subject->subject_name, 'y' => $subjectlikes];
  
              $count++;
          }
  
          usort($this->subject_visits, function ($item1, $item2) {
              return $item2['y'] <=> $item1['y'];
          });
  
          usort($this->subject_likes, function ($item1, $item2) {
              return $item2['y'] <=> $item1['y'];
          });
        
          $this->notes = PanunoteNotes::select('note_id', 'note_title')
          ->where('user_id', session('USER_ID'))
          ->get();
  
          $count = 0;
          foreach($this->notes as $note){
              $notelikes = PanunoteNoteLikes::where('note_id', $note->note_id)
              ->whereBetween('created_at', [$this->startDate, $this->endDate])
              ->where('note_like', 1)->count();

              $notevisits = PanunoteNoteVisits::where('note_id', $note->note_id)
              ->whereBetween('created_at', [$this->startDate, $this->endDate])
              ->count();
  
              $this->notes[$count]['note_likes'] = $notelikes;
              $this->notes[$count]['note_visits'] = $notevisits;
  
              $this->note_visits[] = ['x' => $note->note_title, 'y' => $notevisits];
              $this->note_likes[] = ['x' => $note->note_title, 'y' => $notelikes];
              
              $count++;
          }
  
          usort($this->note_visits, function ($item1, $item2) {
              return $item2['y'] <=> $item1['y'];
          });
  
          usort($this->note_likes, function ($item1, $item2) {
              return $item2['y'] <=> $item1['y'];
          });
  
          $this->quizzes = PanunoteQuizzes::select('quiz_id', 'quiz_title')
          ->where('user_id', session('USER_ID'))
          ->get();


          $count = 0;
          foreach($this->quizzes as $quiz){
              $quizlikes = PanunoteQuizLikes::where('quiz_id', $quiz->quiz_id)
              ->whereBetween('created_at', [$this->startDate, $this->endDate])
              ->where('quiz_like', 1)
              ->count();

              $quizvisits = PanunoteQuizVisits::where('quiz_id', $quiz->quiz_id)
              ->whereBetween('created_at', [$this->startDate, $this->endDate])
              ->count();
  
              $this->quizzes[$count]['quiz_likes'] = $quizlikes;
              $this->quizzes[$count]['quiz_visits'] = $quizvisits;
  
              $this->quiz_visits[] = ['x' => $quiz->quiz_title, 'y' => $quizvisits];
              $this->quiz_likes[] = ['x' => $quiz->quiz_title, 'y' => $quizlikes];
  
              $count++;
          }
          

          usort($this->quiz_visits, function ($item1, $item2) {
              return $item2['y'] <=> $item1['y'];
          });
  
          usort($this->quiz_likes, function ($item1, $item2) {
              return $item2['y'] <=> $item1['y'];
          });
  
     
  
          $this->subject_like_datasets = [
              [
                  'label' => 'Subject Likes',
                  'backgroundColor' => '#0295a9',
                  'borderColor' => '#0295a9',
                  'data' => $this->subject_likes,
              ],
          ];
  
          $this->subject_visits_datasets = [
              [
                  'label' => 'Subject Visits',
                  'backgroundColor' => '#0295a9',
                  'borderColor' => '#0295a9',
                  'data' => $this->subject_visits,
              ],
          ];
  
          $this->note_like_datasets = [
              [
                  'label' => 'Note Likes',
                  'backgroundColor' => '#0295a9',
                  'borderColor' => '#0295a9',
                  'data' => $this->note_likes,
              ],
          ];
  
          $this->note_visits_datasets = [
              [
                  'label' => 'Note Visits',
                  'backgroundColor' => '#0295a9',
                  'borderColor' => '#0295a9',
                  'data' => $this->note_visits,
              ],
          ];
  
          $this->quiz_like_datasets = [
              [
                  'label' => 'Quiz Likes',
                  'backgroundColor' => '#0295a9',
                  'borderColor' => '#0295a9',
                  'data' => $this->quiz_likes,
              ],
          ];
  
          $this->quiz_visits_datasets = [
              [
                  'label' => 'Quiz Visits',
                  'backgroundColor' => '#0295a9',
                  'borderColor' => '#0295a9',
                  'data' => $this->quiz_visits,
              ],
          ];
   
          $this->emit('update_subject_likes', ['datasets' => $this->subject_like_datasets]);
          $this->emit('update_subject_visits', ['datasets' => $this->subject_visits_datasets]);
  
          $this->emit('update_note_likes', ['datasets' => $this->note_like_datasets]);
          $this->emit('update_note_visits', ['datasets' => $this->note_visits_datasets]);
          
          $this->emit('update_quiz_likes', ['datasets' => $this->quiz_like_datasets]);
          $this->emit('update_quiz_visits', ['datasets' => $this->quiz_visits_datasets]);
    }

    public function alltime_data(){

        $this->psubject_visits = [];
        $this->pnote_visits = [];
        $this->pquiz_visits = [];
        $this->pquiz_takes = [];

        //subjects 
        $psubject_visits_all = PanunoteSubjectVisits::where('user_id', session('USER_ID'))->limit(3)->get();
        $ids = [];

        foreach($psubject_visits_all as $psubject_visit){
            $ids[$psubject_visit->subject_id] = $psubject_visit->subject_id;
        }

        foreach($ids as $id){
            $this->psubject_visits[$id]['subject_count'] = PanunoteSubjectVisits::where('subject_id', $id)->where('user_id', session('USER_ID'))->count();
            $this->psubject_visits[$id]['subject_name'] = PanunoteSubjects::select('subject_id', 'subject_name')->where('subject_id', $id)->first()->subject_name;
        }

        usort($this->psubject_visits, function ($item1, $item2) {
            return $item2['subject_count'] <=> $item1['subject_count'];
        });

        //notes

        $pnote_visits_all = PanunoteNoteVisits::where('user_id', session('USER_ID'))->limit(3)->get();
        $ids = [];

        foreach($pnote_visits_all as $pnote_visit){
            $ids[$pnote_visit->note_id] = $pnote_visit->note_id;
        }

        foreach($ids as $id){
            $this->pnote_visits[$id]['note_count'] = PanunoteNoteVisits::where('note_id', $id)->where('user_id', session('USER_ID'))->count();
            $this->pnote_visits[$id]['note_title'] = PanunoteNotes::select('note_id', 'note_title')->where('note_id', $id)->first()->note_title;
        }

        usort($this->pnote_visits, function ($item1, $item2) {
            return $item2['note_count'] <=> $item1['note_count'];
        });
        
        //quizzes

        $pquiz_visits_all = PanunoteQuizVisits::where('user_id', session('USER_ID'))->limit(3)->get();
        $ids = [];

        foreach($pquiz_visits_all as $pquiz_visit){
            $ids[$pquiz_visit->quiz_id] = $pquiz_visit->quiz_id;
        }

        foreach($ids as $id){
            $this->pquiz_visits[$id]['quiz_count'] = PanunoteQuizVisits::where('quiz_id', $id)->where('user_id', session('USER_ID'))->count();
            $this->pquiz_visits[$id]['quiz_title'] = PanunoteQuizzes::select('quiz_title')->where('quiz_id', $id)->first()->quiz_title;
        }

        
        usort($this->pquiz_visits, function ($item1, $item2) {
            return $item2['quiz_count'] <=> $item1['quiz_count'];
        });


        //quizzes takes

        $pquiz_takes_all = PanunoteQuizTakes::where('user_id', session('USER_ID'))->limit(3)->get();
        $ids = [];

        foreach($pquiz_takes_all as $pquiz_take){
            $ids[$pquiz_take->quiz_id] = $pquiz_take->quiz_id;
        }

        foreach($ids as $id){
            $this->pquiz_takes[$id]['quiz_title'] = PanunoteQuizzes::select('quiz_title')->where('quiz_id', $id)->first()->quiz_title;
            $this->pquiz_takes[$id]['quiz_average'] = PanunoteQuizTakes::where('quiz_id', $id)->where('user_id', session('USER_ID'))->avg('user_average');
        }

        usort($this->pquiz_takes, function ($item1, $item2) {
            return $item2['quiz_average'] <=> $item1['quiz_average'];
        });

          
        $this->subject_visits = [];
        $this->subject_likes = [];

        $this->note_visits = [];
        $this->note_likes = [];

        $this->quiz_visits = [];
        $this->quiz_likes = [];

        // $this->startDate = Carbon::createFromFormat('Y-m-d', '2022-12-01')->startOfDay();
        // $this->endDate = Carbon::createFromFormat('Y-m-d', '2022-12-30')->endOfDay();
        // $posts = PanunoteSubjectVisits::whereBetween('created_at', [$startDate, $endDate])->count();
        
        $this->subjects = PanunoteSubjects::select('subject_id', 'subject_name')
        ->where('user_id', session('USER_ID'))->get();

        $count = 0;
        foreach($this->subjects as $subject){
            $subjectlikes = PanunoteSubjectLikes::where('subject_id', $subject->subject_id)->where('subject_like', 1)->count();
            $subjectvisits = PanunoteSubjectVisits::where('subject_id', $subject->subject_id)->count();
            
            $this->subjects[$count]['subject_likes'] = $subjectlikes;
            $this->subjects[$count]['subject_visits'] = $subjectvisits;

            $this->subject_visits[$count] = ['x' => $subject->subject_name, 'y' => $subjectvisits];
            $this->subject_likes[$count] = ['x' => $subject->subject_name, 'y' => $subjectlikes];

            $count++;
        }

        usort($this->subject_visits, function ($item1, $item2) {
            return $item2['y'] <=> $item1['y'];
        });

        usort($this->subject_likes, function ($item1, $item2) {
            return $item2['y'] <=> $item1['y'];
        });
      
        $this->notes = PanunoteNotes::select('note_id', 'note_title')
        ->where('user_id', session('USER_ID'))
        ->get();

        $count = 0;
        foreach($this->notes as $note){
            $notelikes = PanunoteNoteLikes::where('note_id', $note->note_id)->where('note_like', 1)->count();
            $notevisits = PanunoteNoteVisits::where('note_id', $note->note_id)->count();

            $this->notes[$count]['note_likes'] = $notelikes;
            $this->notes[$count]['note_visits'] = $notevisits;

            $this->note_visits[] = ['x' => $note->note_title, 'y' => $notevisits];
            $this->note_likes[] = ['x' => $note->note_title, 'y' => $notelikes];
            
            $count++;
        }

        usort($this->note_visits, function ($item1, $item2) {
            return $item2['y'] <=> $item1['y'];
        });

        usort($this->note_likes, function ($item1, $item2) {
            return $item2['y'] <=> $item1['y'];
        });

        $this->quizzes = PanunoteQuizzes::select('quiz_id', 'quiz_title')
        ->where('user_id', session('USER_ID'))
        ->get();

        $count = 0;
        foreach($this->quizzes as $quiz){
            $quizlikes = PanunoteQuizLikes::where('quiz_id', $quiz->quiz_id)->where('quiz_like', 1)->count();
            $quizvisits = PanunoteQuizVisits::where('quiz_id', $quiz->quiz_id)->count();

            $this->quizzes[$count]['quiz_likes'] = $quizlikes;
            $this->quizzes[$count]['quiz_visits'] = $quizvisits;

            $this->quiz_visits[] = ['x' => $quiz->quiz_title, 'y' => $quizvisits];
            $this->quiz_likes[] = ['x' => $quiz->quiz_title, 'y' => $quizlikes];

            $count++;
        }

        usort($this->quiz_visits, function ($item1, $item2) {
            return $item2['y'] <=> $item1['y'];
        });

        usort($this->quiz_likes, function ($item1, $item2) {
            return $item2['y'] <=> $item1['y'];
        });


        $this->subject_like_datasets = [
            [
                'label' => 'Subject Likes',
                'backgroundColor' => '#0295a9',
                'borderColor' => '#0295a9',
                'data' => $this->subject_likes,
            ],
        ];

        $this->subject_visits_datasets = [
            [
                'label' => 'Subject Visits',
                'backgroundColor' => '#0295a9',
                'borderColor' => '#0295a9',
                'data' => $this->subject_visits,
            ],
        ];

        $this->note_like_datasets = [
            [
                'label' => 'Note Likes',
                'backgroundColor' => '#0295a9',
                'borderColor' => '#0295a9',
                'data' => $this->note_likes,
            ],
        ];

        $this->note_visits_datasets = [
            [
                'label' => 'Note Visits',
                'backgroundColor' => '#0295a9',
                'borderColor' => '#0295a9',
                'data' => $this->note_visits,
            ],
        ];

        $this->quiz_like_datasets = [
            [
                'label' => 'Quiz Likes',
                'backgroundColor' => '#0295a9',
                'borderColor' => '#0295a9',
                'data' => $this->quiz_likes,
            ],
        ];

        $this->quiz_visits_datasets = [
            [
                'label' => 'Quiz Visits',
                'backgroundColor' => '#0295a9',
                'borderColor' => '#0295a9',
                'data' => $this->quiz_visits,
            ],
        ];

    }

    public function render()
    {
        if($this->alltime){
            $this->alltime_data();

            // dd(
            // $this->subject_like_datasets, $this->subject_visits_datasets, 
            // "#####################", 
            // $this->note_like_datasets, $this->note_visits_datasets,
            // "#####################", 
            // $this->quiz_like_datasets, $this->quiz_visits_datasets
            // );

            $this->emit('update_subject_likes', ['datasets' => $this->subject_like_datasets]);
            $this->emit('update_subject_visits', ['datasets' => $this->subject_visits_datasets]);
    
            $this->emit('update_note_likes', ['datasets' => $this->note_like_datasets]);
            $this->emit('update_note_visits', ['datasets' => $this->note_visits_datasets]);
            
            $this->emit('update_quiz_likes', ['datasets' => $this->quiz_like_datasets]);
            $this->emit('update_quiz_visits', ['datasets' => $this->quiz_visits_datasets]);
        }

        // if($this->alltime){

        //     $this->quiz_visits[0] = ['x' => 'qweqweqwe', 'y' => 345345345];
        //     $this->quiz_visits[1] = ['x' => '34', 'y' => 2343545];
            
        //     $this->quiz_visits_datasets = [
        //         [
        //             'label' => 'Quiz Visits',
        //             'backgroundColor' => '#000000',
        //             'borderColor' => '#000000',
        //             'data' => $this->quiz_visits,
        //         ],
        //     ];
            
        //     $this->emit('updateChart2', ['datasets' => $this->quiz_visits_datasets]);
        // }

        return view('livewire.panunote-analytics');
    }
}

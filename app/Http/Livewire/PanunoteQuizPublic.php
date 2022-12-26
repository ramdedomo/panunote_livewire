<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteAnswers;
use App\Models\PanunoteQuestions;
use App\Models\PanunoteQuizLikes;
use App\Models\PanunoteUsers;
use App\Models\PanunoteNotes;
use App\Models\PanunoteQuizVisits;
use Carbon\Carbon;
use URL;
use DB;

class PanunoteQuizPublic extends Component
{
 
    public $quiz_id;

    public $emitquestion = [];
    public $questions = [];
    public $questionsvalue = [];
    public $quizname;

    public $identification = [];

    public $multiplechoices = [];
    public $answer = [];
    public $multiplerightanswer = [];

    public $anwerquestionid = [];
    public $questiontype = [];
    public $questiondifficulty = [];

    public $show = [];
    public $isfavorite = false;
    public $answertype = [];

    public function mount($quiz_id=null){
        $this->quiz_id = $quiz_id;

        //get quiz details
        $quiz = DB::table('panunote_quizzes')
        ->where('quiz_id', $this->quiz_id)
        ->first();

        if(!is_null($quiz)){
            if(session('USER_ID') != $quiz->user_id){
                if($quiz->quiz_sharing == "1" && !empty(session('USER_ID'))){
    
                }elseif($quiz->quiz_sharing == "0" && !empty(session('USER_ID'))){
                    dd("Private");
                }else{
                    abort(404);
                }
            }
        }else{
            abort(404);
        }

        //visits count
        //check if exists
        $isexists = PanunoteQuizVisits::where('quiz_id', $this->quiz_id)
        ->where('user_id', session('USER_ID'))
        ->exists();

        if($isexists){
            $updated = PanunoteQuizVisits::where('quiz_id', $this->quiz_id)
            ->where('user_id', session('USER_ID'))
            ->orderBy('created_at', 'desc')
            ->first('updated_at');

            if((Carbon::now())->gte(Carbon::parse($updated->updated_at)->addSeconds(60))){
                PanunoteQuizVisits::create([
                    'quiz_id' => $this->quiz_id,
                    'user_id' => session('USER_ID'),
                ]);
            }
        }else{
            PanunoteQuizVisits::create([
                'quiz_id' => $this->quiz_id,
                'user_id' => session('USER_ID'),
            ]);
        }


        $this->quizname = $quiz->quiz_title;

        ///sharing
        $this->sharing = ($quiz->quiz_sharing == 0) ? false : true;

        $this->urlsharing = URL::current();

        if($this->sharing == "true"){
          $this->urlsharing = $this->urlsharing;
        }else{
          $this->urlsharing = "";
        }

        //get all questions from quiz
        $this->questions = DB::table('panunote_questions')
        ->where('quiz_id', $this->quiz_id)
        ->get()
        ->toArray();

        //passing questions to questions model in view
        foreach($this->questions as $q){
            
            $this->questionsvalue[$q->question_id] = $q->question_text;  
            $this->questiontype[$q->question_id] = $q->question_type;
            $this->questiondifficulty[$q->question_id] = $q->question_difficulty;
            
            //multiple choice
            if($q->question_type == 1){
                //Ex. multiplechoices.1,multiplechoices.2 ...
                $this->multiplechoices[$q->question_id] = PanunoteAnswers::where('question_id', $q->question_id)->get();

                //sending answer text to model in view
                    foreach($this->multiplechoices[$q->question_id] as $a){

                        $this->anwerquestionid[$a->answer_id] = $q->question_id;
                        $this->answertype[$a->answer_id] = $a->answer_type;
                        //sending the right answer to blade view
                        if($a->is_right == 1){
                            $this->multiplerightanswer[$a->answer_id] = true;
                        }

                        $this->show[$a->answer_id] = true;

                        //Ex. answer.1,answer.2 ...
                        $this->answer[$a->answer_id] = $a->answer_text;
                    }

            //identification
            }elseif($q->question_type == 2){
                //just passing the answer in identification
                $this->multiplechoices[$q->question_id] = PanunoteAnswers::where('question_id', $q->question_id)->get();
                //sending answer text to model in view
                    foreach($this->multiplechoices[$q->question_id] as $a){
                        $this->answertype[$a->answer_id] = $a->answer_type;
                        //Ex. answer.1,answer.2 ...
                        $this->answer[$a->answer_id] = $a->answer_text;
                        $this->anwerquestionid[$a->answer_id] = $q->question_id;

                        $this->show[$a->answer_id] = true;
                        $this->identification[$a->answer_id] = PanunoteAnswers::where('question_id', $q->question_id)->first()->answer_text;
                    }
            }
        }

        $like = PanunoteQuizLikes::where([
            ['quiz_id', $this->quiz_id],
            ['user_id', session('USER_ID')]
        ])->first();

        $this->isfavorite = (!is_null($like) && $like->quiz_like == 1) ? true : false;

    }

    public function like(){
        $this->isfavorite = !$this->isfavorite;

        $isexist = PanunoteQuizLikes::where([
            ['quiz_id', $this->quiz_id],
            ['user_id', session('USER_ID')]
        ])->exists();

        if($isexist){
            //update
            PanunoteQuizLikes::where('quiz_id', $this->quiz_id)
            ->where('user_id', session('USER_ID'))
            ->update(['quiz_like' => ($this->isfavorite) ? 1 : 0]);

        }else{
            //create
            PanunoteQuizLikes::create([
                'quiz_id' => $this->quiz_id,
                'user_id' => session('USER_ID'),
                'quiz_like' => ($this->isfavorite) ? 1 : 0
            ]);
        }

    }

    public function render()
    {
        $quiz_details = PanunoteQuizzes::where('quiz_id', $this->quiz_id)->first();
        return view('livewire.public.panunote-quiz-public', ['quiz_details' => $quiz_details]);
    }
}

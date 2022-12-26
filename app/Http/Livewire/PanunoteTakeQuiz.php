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
use App\Models\PanunoteQuizVisits;
use App\Models\PanunoteQuizTakes;
use Carbon\Carbon;
use URL;
use DB;

class PanunoteTakeQuiz extends Component
{
    public $quiz_id;
    public $questions;
    public $quiz_details;
    public $useranswer = [];
    public $correctanswer = [];
    public $result = [];
    public $score = 0;
    public $total = 0;

    public function submit(){

        $qstns = PanunoteQuestions::where('quiz_id', $this->quiz_id)->get();
        $this->total = count($qstns);

        $count = 0;
        foreach($qstns as $question){

            $qstns[$count]['answers'] = PanunoteAnswers::where('question_id', $question->question_id)->get();

            $count_answer = $qstns[$count]['count'] = PanunoteAnswers::where('question_id', $question->question_id)
            ->where('is_right', 1)
            ->count();

            $qstns[$count]['right_answer'] = PanunoteAnswers::where('question_id', $question->question_id)
            ->where('is_right', 1)
            ->get();

            if($count_answer > 1){
                //if multiple answer
                foreach($qstns[$count]['right_answer'] as $rightans){
                    if($rightans->is_right == 1){
                        $this->correctanswer[$question->question_id][] = $rightans->answer_text;
                    }
                }

            }else{
                //one answer
                foreach($qstns[$count]['right_answer'] as $rightans){
                    if($rightans->is_right == 1){
                        $this->correctanswer[$question->question_id] = $rightans->answer_text;
                    }
                }
            }

            $count++;
        }

        //checking



        foreach($this->correctanswer as $ans_key => $ans_value){

            if(is_array($ans_value)){

                if(!empty($this->useranswer[$ans_key])){
                    foreach($ans_value as $userans){
                        if(in_array($userans, $this->useranswer[$ans_key])){
                            $res = true;
                        }else{
                            $res = false;
                            break;
                        }
                    }

                    if($res){
                        $this->score++;
                        $this->result[$ans_key]['iscorrect'] = 0;
                        $this->result[$ans_key]['correct_answer'] = $this->correctanswer[$ans_key];
                    }else{
                        $this->result[$ans_key]['iscorrect'] = 1;
                        $this->result[$ans_key]['correct_answer'] = $this->correctanswer[$ans_key];
                    }
                }else{
                    $this->result[$ans_key]['iscorrect'] = 2;
                    $this->result[$ans_key]['correct_answer'] = $this->correctanswer[$ans_key];
                }
                
            }else{

                if(!empty($this->useranswer[$ans_key])){
                    if($ans_value == $this->useranswer[$ans_key]){
                        $this->score++;
                        $this->result[$ans_key]['iscorrect'] = 0;
                        $this->result[$ans_key]['correct_answer'] = $this->correctanswer[$ans_key];
                    }else{
                        $this->result[$ans_key]['iscorrect'] = 1;
                        $this->result[$ans_key]['correct_answer'] = $this->correctanswer[$ans_key];
                    }
                }else{
                    $this->result[$ans_key]['iscorrect'] = 2;
                    $this->result[$ans_key]['correct_answer'] = $this->correctanswer[$ans_key];
                }

                
            }
        }


        //visits count
        //check if exists
        if($this->quiz_details->user_id != session('USER_ID')){
            $isexists = PanunoteQuizTakes::where('quiz_id', $this->quiz_id)
            ->where('user_id', session('USER_ID'))
            ->exists();
    
            if($isexists){
                $updated = PanunoteQuizTakes::where('quiz_id', $this->quiz_id)
                ->where('user_id', session('USER_ID'))
                ->orderBy('created_at', 'desc')
                ->first('updated_at');

                if((Carbon::now())->gte(Carbon::parse($updated->updated_at)->addSeconds(60))){
                    PanunoteQuizTakes::create([
                        'quiz_id' => $this->quiz_id,
                        'user_id' => session('USER_ID'),
                        'user_average' => (($this->score / $this->total) * 100),
                    ]);
                }
            }else{
                PanunoteQuizTakes::create([
                    'quiz_id' => $this->quiz_id,
                    'user_id' => session('USER_ID'),
                    'user_average' => (($this->score / $this->total) * 100),
                ]);
            }
        }
      
        $this->dispatchBrowserEvent('show-result');
    }

    public function mount($quiz_id=null){
        $this->quiz_id = $quiz_id;
        $this->quiz_details = PanunoteQuizzes::where('quiz_id', $this->quiz_id)->first();
        //visits count
        //check if exists
        if($this->quiz_details->user_id != session('USER_ID')){
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
        }
        
    }


    public function render()
    {
       

        if(is_null($this->quiz_details)){
            abort(404);
        }

        $this->questions = PanunoteQuestions::where('quiz_id', $this->quiz_id)->get();

        $count = 0;
        foreach($this->questions as $question){
            $this->questions[$count]['answers'] = PanunoteAnswers::where('question_id', $question->question_id)->get();
            $this->questions[$count]['right_answer'] = PanunoteAnswers::where('question_id', $question->question_id)
            ->where('is_right', 1)
            ->count();

            $count++;
        }

        return view('livewire.panunote-take-quiz', ['questions' => $this->questions, 'quiz_details' => $this->quiz_details])->layout('layouts.testbase');
    }
}

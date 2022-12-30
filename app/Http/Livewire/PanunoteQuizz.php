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
use App\Models\PanunoteGamificationRoom;
use App\Models\PanunoteGamificationInroom;
use App\Models\PanunoteUsers;
use App\Models\PanunoteNotes;
use App\Models\PanunoteQuizVisits;
use App\Models\PanunoteQuizTakes;
use URL;
use DB;

class PanunoteQuizz extends Component
{
    protected $listeners = [
        'set:savechanges' => 'savechanges',
    ];

    public $quiz_id;
    public $quiz_details;

    public $saved = false;

    public $emitquestion = [];
    public $questions = [];
    public $questionsvalue = [];
    public $quizname;

    public $identification = [];

    public $multiplechoices = [];
    public $answer = [];
    public $multiplerightanswer = [];
    public $addchoicefield = [];

    public $anwerquestionid = [];
    public $questiontype = [];
    public $questiondifficulty = [];

    public $answercount = [];

    public $show = [];
    public $isfavorite = false;
    public $answertype = [];
    public $publicid = [];


    public $quiztags;

    public $quizvisits_count;
    public $quiztakes_count;
    public $quizlikes_count;

    public $preserveroom = true;

    public function delete(){

        if(PanunoteGamificationRoom::where('quiz_id', $this->quiz_id)->exists()){
            if($this->preserveroom){
                PanunoteGamificationRoom::where('quiz_id', $this->quiz_id)
                ->update([
                    'quiz_id' => null
                ]);
            }else{
                $a = PanunoteGamificationRoom::where('quiz_id', $this->quiz_id)->first();
                PanunoteGamificationInroom::where('game_id',  $a->game_id)->delete();
                PanunoteGamificationRoom::where('quiz_id', $this->quiz_id)->delete();
            }
        }

        PanunoteQuizVisits::where('quiz_id', $this->quiz_id)->delete();
        PanunoteQuizTakes::where('quiz_id', $this->quiz_id)->delete();
        PanunoteQuizLikes::where('quiz_id', $this->quiz_id)->delete();

        $delete_questions = [];
        foreach(PanunoteQuestions::select('question_id')->where('quiz_id', $this->quiz_id)->get() as $q){
            $delete_questions[] = $q->question_id;
        }

        PanunoteAnswers::whereIn('question_id', $delete_questions)->delete();
        PanunoteQuestions::where('quiz_id', $this->quiz_id)->delete();
        PanunoteQuizzes::where('quiz_id', $this->quiz_id)->delete();

        return redirect('quizzes');
    }

    public function create(){

        //dd($this->multiplerightanswer);
       // dd($this->questiontype);

        $a = [
            'question_id' => rand(11111111,99999999),
            'quiz_id' => $this->quiz_id,
            'question_text' => "Question Here",
            'question_type' => 2,
            'question_difficulty' => 1
        ];

        $b = [
            'answer_id' => rand(11111111,99999999),
            'question_id' => $a['question_id'],
            'answer_text' => "Answer Here",
            'is_right' =>  1,
            'answer_type' => 2,
            'is_disabled' => 0
        ];

        $this->questiontype[$a['question_id']] = $a['question_type'];

        $this->questions[] = $a;
        
        $this->multiplechoices[$a['question_id']] = [$b];
        
        $this->questionsvalue[$a['question_id']] = $a['question_text'];
        $this->answercount[$a['question_id']] = 1;

        //if identification
        $this->identification[$b['answer_id']] = $b['answer_text'];

        $this->answer[$b['answer_id']] = $b['answer_text'];

        //$this->multiplerightanswer[$b['answer_id']] = true;

        $this->show[$b['answer_id']] = true;
        $this->answertype[$b['answer_id']] = $b['answer_type'];

        $this->anwerquestionid[$b['answer_id']] = $a['question_id'];
        $this->questiondifficulty[$a['question_id']] = $a['question_difficulty'];


        $this->dispatchBrowserEvent('newquestion', ['question_id' => $a['question_id']]);
    }

    public function updateTag(){
        $this->quiz_details->quiz_tags = $this->quiztags;
    }


    public function mount($quiz_id=null){

    
        $this->quiz_details = PanunoteQuizzes::where('quiz_id', $this->quiz_id)->first();
        $this->quiztags = $this->quiz_details->quiz_tags;

        $this->quiz_id = $quiz_id;

        //get quiz details
        $quiz = DB::table('panunote_quizzes')
        ->where('quiz_id', $this->quiz_id)
        ->first();

        if(!is_null($quiz)){
            if(session('USER_ID') != $quiz->user_id){
                if($quiz->quiz_sharing == "1" && !empty(session('USER_ID'))){
    
                    $a = PanunoteUsers::where('user_id', $quiz->user_id)->first('username');
                    return redirect()->to('/'.$a->username.'/quizzes/'.$this->quiz_id);
    
                }elseif($quiz->quiz_sharing == "0" && !empty(session('USER_ID'))){
                    dd("Private");
                }else{
                    abort(404);
                }
            }
        }else{
            abort(404);
        }



        $this->quizname = $quiz->quiz_title;

        $a = DB::table('panunote_answers')
        ->where('is_disabled', 1)
        ->get();

        if(!is_null($a)){
            foreach($a as $public){
                $this->publicid[$public->question_id] = $public->answer_id;
            }
        }

        //dd($this->publicid);

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
        $this->answercount = array_count_values(array_values($this->anwerquestionid));

        
        //analytics
        $this->quizlikes_count = PanunoteQuizLikes::where('quiz_id', $this->quiz_id)->where('quiz_like', 1)->count();
        $this->quizvisits_count = PanunoteQuizVisits::where('quiz_id', $this->quiz_id)->count();
        $this->quiztakes_count = PanunoteQuizTakes::where('quiz_id', $this->quiz_id)->count();
    }


    public function addchoicenew($questionid){

        $id = rand(11111111,99999999);

        if(empty($this->addchoicefield[$questionid])){
            $this->addchoicefield[$questionid] = "";
        }

        $newanswer = [
            "answer_id" => $id,
            "question_id" => $questionid,
            "answer_text" => $this->addchoicefield[$questionid],
            "answer_type" => 1,
            "is_right" => false
        ];
 
        $this->answertype[$id] = 1;
        //disaplying to newly added choice
        $this->answer[$id] = $this->addchoicefield[$questionid];
        //add choice count
        $this->answercount[$questionid]++;
        //showing newly added choice
        $this->show[$id] = true;
        //add to anwerquestionid
        $this->anwerquestionid[$id] = $questionid;
        //add to multiplechoices of certain qeustion id
        $this->multiplechoices[$questionid][] = $newanswer;

        unset($this->identification[$id]);
        $this->publicid[$questionid] = $id;
    }

    public function sharingsetting(){
        $this->sharing = $this->sharing;

        PanunoteQuizzes::where('quiz_id', $this->quiz_id)
        ->update(['quiz_sharing' => ($this->sharing == "true") ? 1 : 0]);

        if($this->sharing == "true"){
            $this->urlsharing = URL::previous();
        }else{
            $this->urlsharing = "";
        }
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
    
    public function quiztypechanged($question_id, $answer_id){

        $this->publicid[$question_id] = $answer_id;

        if($this->questiontype[$question_id] == 2){
            //unset($this->answer[$answer_id]);
            $this->identification[$answer_id] = $this->answer[$answer_id];
            $this->answertype[$answer_id] = 2;
            $this->questiontype[$question_id] = 2;
        }elseif($this->questiontype[$question_id] == 1){
            //unset($this->identification[$answer_id]);
            //$this->answer[$answer_id] = "";
            $this->answertype[$answer_id] = 1;
            $this->questiontype[$question_id] = 1;
        }
    }

    // public function quiztypechanged($question_id, $answer_id){

    //     $this->publicid[$question_id] = $answer_id;

    //     if($this->questiontype[$question_id] == 2){
    //         unset($this->answer[$answer_id]);
    //         $this->identification[$answer_id] = "";
    //         $this->answertype[$answer_id] = 2;
    //         $this->questiontype[$question_id] = 2;
    //     }elseif($this->questiontype[$question_id] == 1){
    //         unset($this->identification[$answer_id]);
    //         $this->answer[$answer_id] = "";
    //         $this->answertype[$answer_id] = 1;
    //         $this->questiontype[$question_id] = 1;
    //     }
    // }




    public function deletequestion($questionid){

        

        foreach($this->anwerquestionid as $ans_id => $ques_id){
            if($ques_id == $questionid){
                if($this->questiontype[$questionid] == 1){
                    unset($this->answer[$ans_id]);
                }else{
                    unset($this->identification[$ans_id]);
                }
                unset($this->show[$ans_id]);
                unset($this->answertype[$ans_id]);
                unset($this->anwerquestionid[$ans_id]);
            }
        }

        unset($this->questiontype[$questionid]);
        unset($this->questions[$questionid]);
        unset($this->multiplechoices[$questionid]);
        unset($this->questionsvalue[$questionid]);
        unset($this->answercount[$questionid]);
        unset($this->questiondifficulty[$questionid]);

        $this->savechanges();
        $this->saved = true;


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

 
        $this->answercount = array_count_values(array_values($this->anwerquestionid));
        $this->dispatchBrowserEvent('deleted', ['questions' => $this->questions]);
        return redirect(request()->header('Referer'));
    }

    public function deletechoice($answerid, $questionid){
        if($answerid == $this->publicid[$questionid]){
            $this->answercount[$questionid]--;
            $this->show[$answerid] = false;
            unset($this->multiplerightanswer[$answerid]);
        }else{
            unset($this->answer[$answerid]);
            $this->answercount[$questionid]--;
            $this->show[$answerid] = false;
            unset($this->multiplerightanswer[$answerid]);
            unset($this->anwerquestionid[$answerid]);
            unset($this->answertype[$answerid]);
        }
    }

    public function savechanges(){

        $this->dispatchBrowserEvent('quizsaved');

        PanunoteQuizzes::where('quiz_id', $this->quiz_id)
        ->update([
            'quiz_title' => $this->quizname,
            'quiz_tags' => $this->quiztags
        ]);

        foreach($this->questiondifficulty as $answerid => $difficulty){
            if($difficulty < 1 && $difficulty > 3){
                $this->dispatchBrowserEvent('error');
            }
        }

        foreach($this->questiontype as $answerid => $type){
            if($type < 1 && $type > 2){
                $this->dispatchBrowserEvent('error');
            }
        }
        
        
        $finalanswer = [];
        $finalanswerid = [];
        $finalanswertype = [];

        foreach($this->answertype as $answerid => $type){
            if($type == 1 && $this->questiontype[$this->anwerquestionid[$answerid]] == 1){
                $finalanswer[$answerid] = $this->answer[$answerid];
                $finalanswertype[$answerid] = 1;
            }elseif($type == 2 && $this->questiontype[$this->anwerquestionid[$answerid]] == 2){
                $finalanswer[$answerid] = $this->identification[$answerid];
                $finalanswertype[$answerid] = 2;
                $this->multiplerightanswer[$answerid] = true;
            }   
        }

        //dd($this->questionsvalue, $this->questiondifficulty, $finalanswer, $this->multiplerightanswer, $finalanswertype,  $this->anwerquestionid);
        //dd($this->questiondifficulty, $this->anwerquestionid, $this->questionsvalue, $finalanswer, $finalanswertype, $this->multiplerightanswer);

        
        //delete
        $questions = PanunoteQuestions::where('quiz_id', $this->quiz_id)->get('question_id');
        foreach($questions as $q){
            PanunoteAnswers::where('question_id', $q->question_id)->delete();
        }

        PanunoteQuestions::where('quiz_id', $this->quiz_id)->delete();

        //create questions
        foreach($this->questionsvalue as $id => $question){
            PanunoteQuestions::create([
                'question_id' => $id,
                'question_text' => $question,
                'quiz_id' => $this->quiz_id,
                'question_type'=> $this->questiontype[$id],
                'question_difficulty' => $this->questiondifficulty[$id]
            ]);
        }

        //create questions
        // foreach($this->questionsvalue as $id => $question){

        //     if(PanunoteQuestions::where('question_id', $id)->exists()){
        //         PanunoteQuestions::where('question_id', $id)
        //         ->update([
        //             'question_text' => $question,
        //             'quiz_id' => $this->quiz_id,
        //             'question_type'=> $this->questiontype[$id],
        //             'question_difficulty' => $this->questiondifficulty[$id]
        //         ]);
        //     }else{
        //         PanunoteQuestions::create([
        //             'question_id' => $id,
        //             'question_text' => $question,
        //             'quiz_id' => $this->quiz_id,
        //             'question_type'=> $this->questiontype[$id],
        //             'question_difficulty' => $this->questiondifficulty[$id]
        //         ]);
        //     }
        // }

        //dd($this->anwerquestionid);

        //create answers
        foreach($finalanswer as $id => $answer){
            PanunoteAnswers::create([
                'question_id' => $this->anwerquestionid[$id],
                'answer_id' => $id,
                'answer_text' => $answer,
                'is_right'=> (in_array($id, array_keys($this->multiplerightanswer)) && $this->multiplerightanswer[$id]) ? 1 : 0,
                'answer_type' => $finalanswertype[$id],
                'is_disabled' => (in_array($id, $this->publicid)) ? 1 : 0,
            ]);
        }

    
        //dd($this->anwerquestionid, $finalanswer, $finalanswertype, array_keys($this->multiplerightanswer));
        //dd("saved");
        //$this->dispatchBrowserEvent('saved');

        $this->quiz_details->quiz_title = $this->quizname;
        $this->quiz_details->quiz_tags = $this->quiztags;
        $this->saved = true;
    }

    public function render(){


        return view('livewire.panunote-quizz', ['quiz_details' => $this->quiz_details]);
    }

}

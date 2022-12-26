<?php

namespace App\Http\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\PanunoteQuizzes as PanunoteQuizzess;
use App\Models\PanunoteQuestions;
use App\Models\PanunoteNotes;
use App\Models\PanunoteAnswers;
use DB;
use Illuminate\Support\Facades\Validator;

class PanunoteQuizzes extends Component
{

    public $tags = [];
    public $question_diff = [];

    public $quizcreate_title;
    public $quizcreate_count;
    public $quizcreate_tags;
    public $quizcreate_diff;
    public $quizcreate_precision;
    public $quizcreate_sorting;
    public $quizcreate_sharing = false;
    public $autotag = true;

    public $all = [];


    public $quiz_list;
    public $search;
    public $sort = "";

    protected function rules()
    {
        return [
            'quizcreate_title' => 'required|min:6',
            'quizcreate_count' => 'required',
            'quizcreate_tags' => 'required',
            'quizcreate_diff' => 'required',
        ];
    }

    
    public function create_quiz_empty(){

        if(
            empty($this->quizcreate_title) || is_null($this->quizcreate_title)
        ){
            $this->dispatchBrowserEvent('validation_empty');
        }else{

            PanunoteQuizzess::create([
                'user_id' => session('USER_ID'),
                'quiz_sharing' => ($this->quizcreate_sharing) ? 1 : 0,
                'quiz_title' => $this->quizcreate_title
            ]);
          
            $this->dispatchBrowserEvent('createdquiz');
        }

    }

    public function create_quiz(){

        $test = [];
        if(
        empty($this->quizcreate_title) || is_null($this->quizcreate_title) ||
        empty($this->quizcreate_count) || is_null($this->quizcreate_count) ||
        empty($this->quizcreate_tags) || is_null($this->quizcreate_tags) ||
        empty($this->quizcreate_diff) || is_null($this->quizcreate_diff) ||
        empty($this->quizcreate_precision) || is_null($this->quizcreate_precision)
        ){
            $this->dispatchBrowserEvent('validation');
        }else{
            if($this->quizcreate_count < 1 && $this->quizcreate_count > 4){
                $this->dispatchBrowserEvent('error');
            }else{
           

                $selected = [];

                if($this->quizcreate_precision == 1){

                    foreach($this->all as $note){
                        $isprecise = count(array_intersect($this->quizcreate_tags , $note['tags']));
                        if($isprecise >= 1){
                            $selected[] = $note;
                        }
                    }

                }elseif($this->quizcreate_precision == 2){

                    foreach($this->all as $note){
                        $isprecise = count(array_intersect($this->quizcreate_tags , $note['tags']));
                        if($isprecise >= (count($this->quizcreate_tags) / 2)){
                            $selected[] = $note;
                        }
                    }

                }elseif($this->quizcreate_precision == 3){

                    foreach($this->all as $note){
                        $isprecise = count(array_intersect($this->quizcreate_tags , $note['tags']));
                        if($isprecise >= count($this->quizcreate_tags)){
                            $selected[] = $note;
                        }
                    }

                }else{
                    $this->dispatchBrowserEvent('error');
                }


                //function to check multidimensional array
                function in_array_r($needle, $haystack, $strict = false) {
                    foreach ($haystack as $item) {
                        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                            return true;
                        }
                    }
                
                    return false;
                }


                //sort
                if($this->quizcreate_sorting == 1){

                    $final_questions = [];
    
                    foreach($this->quizcreate_diff as $diff){
                        foreach($selected as $sel){
                            foreach($sel['questions'] as $q){
                                if($diff == $q['question_difficulty']){
                                    if(!in_array_r($q['question_text'], $final_questions)){
                                        $q['answers'] = PanunoteAnswers::select('answer_text', 'is_right', 'answer_type')->where('question_id', $q['question_id'])->get()->toArray();
                                        $final_questions[] = $q;
                                    }
                                }  
                            }
                        }
                    }

                    shuffle($final_questions);

                }elseif($this->quizcreate_sorting == 2){

                    $final_questions = [];
                    sort($this->quizcreate_diff);
    
                    foreach($this->quizcreate_diff as $diff){
                        foreach($selected as $sel){
                            foreach($sel['questions'] as $q){
                                if(!in_array_r($q['question_text'], $final_questions)){
                                    $q['answers'] = PanunoteAnswers::select('answer_text', 'is_right', 'answer_type')->where('question_id', $q['question_id'])->get()->toArray();
                                    $final_questions[] = $q;
                                }
                            }
                        }
                    }

                }elseif($this->quizcreate_sorting == 3){

                    $final_questions = [];
                    rsort($this->quizcreate_diff);
    
                    foreach($this->quizcreate_diff as $diff){
                        foreach($selected as $sel){
                            foreach($sel['questions'] as $q){
                                if(!in_array_r($q['question_text'], $final_questions)){
                                    $q['answers'] = PanunoteAnswers::select('answer_text', 'is_right', 'answer_type')->where('question_id', $q['question_id'])->get()->toArray();
                                    $final_questions[] = $q;
                                }
                            }
                        }
                    }

                }else{
                    $final_questions = [];
    
                    foreach($this->quizcreate_diff as $diff){
                        foreach($selected as $sel){
                            foreach($sel['questions'] as $q){
                                if($diff == $q['question_difficulty']){
                                    if(!in_array_r($q['question_text'], $final_questions)){
                                        $q['answers'] = PanunoteAnswers::select('answer_text', 'is_right', 'answer_type')->where('question_id', $q['question_id'])->get()->toArray();
                                        $final_questions[] = $q;
                                    }
                                }  
                            }
                        }
                    }

                    shuffle($final_questions);
                }

                $question_count = 0;
                if($this->quizcreate_count == 1){
                    $question_count = 5;
                }elseif($this->quizcreate_count == 2){
                    $question_count = 10;
                }elseif($this->quizcreate_count == 3){
                    $question_count = 15;
                }elseif($this->quizcreate_count == 4){
                    $question_count = 20;
                }else{
                    $question_count = 5;
                }

            
                //dd(implode(",",$this->quizcreate_tags), $this->quizcreate_diff, array_slice($final_questions, 0, $question_count), $selected, $this->all);
                
                $final = array_slice($final_questions, 0, $question_count);

                $a = PanunoteQuizzess::create([
                    'user_id' => session('USER_ID'),
                    'quiz_sharing' => ($this->quizcreate_sharing) ? 1 : 0,
                    'quiz_title' => $this->quizcreate_title,
                    'quiz_tags' => implode(",",$this->quizcreate_tags)
                ])->quiz_id;

                foreach($final as $q){
                    $b = PanunoteQuestions::create([
                        'quiz_id' => $a,
                        'question_text' => $q['question_text'],
                        'question_type' => $q['question_type'],
                        'question_difficulty' => $q['question_difficulty'],
                    ])->question_id;

                    foreach($q['answers'] as $ans){
                        PanunoteAnswers::create([
                            "question_id" => $b,
                            "answer_text" => $ans['answer_text'],
                            "is_right" => $ans['is_right'],
                            "answer_type" => $ans['answer_type'],
                            "is_disabled" => 0
                        ]);
                    }
                }
                
                $this->dispatchBrowserEvent('createdquiz');
                
                    // $tags = $this->quizcreate_tags;
                    // $test[] = PanunoteNotes::select('note_id')->Where(function ($query) use($tags) {
                    //      for ($i = 0; $i < count($tags); $i++){
                    //         $query->orwhere('note_tags', 'like',  '%' . $tags[$i] .'%');
                    //      }      
                    // })->get();
             
                    // dd($test);

                //dd($this->quizcreate_title,$this->quizcreate_count,$this->quizcreate_tags,$this->quizcreate_diff);
            }
        }

     
      
    }


    public function mount(){

        $allquiz = PanunoteQuizzess::where('quiz_sharing', 1)->get();
        $count = 0;

        foreach($allquiz as $quiz){
            // $allquiz[$count]['questions'] = PanunoteQuestions::where('quiz_id', $quiz->quiz_id)->get()->toArray();
            // $allquiz[$count]['tags'] = PanunoteNotes::select('note_tags')->where('note_id', $quiz->note_id)->get()->toArray();
            $difficulties = PanunoteQuestions::select('question_difficulty')->where('quiz_id', $quiz->quiz_id)->get();

            foreach ($difficulties as $q){
                if (!in_array($q->question_difficulty, $this->question_diff)){
                    $this->question_diff[] = $q->question_difficulty;
                }
            }

            foreach (explode(",", PanunoteQuizzess::select('quiz_tags')->where('quiz_id', $quiz->quiz_id)->first()->quiz_tags) as $t){
                if (!in_array($t, $this->tags)){
                    $this->tags[] = $t;
                }
            }

            $this->all[] = [
                'questions' => PanunoteQuestions::where('quiz_id', $quiz->quiz_id)->get()->toArray(),
                'tags' => explode(",", PanunoteQuizzess::select('quiz_tags')->where('quiz_id', $quiz->quiz_id)->first()->quiz_tags)
            ];


            $count++;
        }



    }


    public function render()
    {
        // $this->quiz_list = PanunoteQuizzess::where('user_id', session('USER_ID'))->get();

        $this->quiz_list = PanunoteQuizzess::searchall($this->search)
        ->where('user_id', session('USER_ID'))
        ->when(empty($this->search), function ($query) {
            $query->where('quiz_id', '>', 0);
        })
        ->when(!empty($this->sort), function ($query) {
            if($this->sort == 'lto'){
                $query->orderBy('updated_at', 'DESC');
            }elseif($this->sort == 'otl'){
                $query->orderBy('updated_at', 'ASC');
            }elseif($this->sort == 'atz'){
                $query->orderBy('quiz_title', 'ASC');
            }elseif($this->sort == 'zta'){
                $query->orderBy('quiz_title', 'DESC');
            }
        })
        ->get();

        $quizcount = 0;
        foreach($this->quiz_list as $quiz){
            $this->quiz_list[$quizcount]['quiz_count'] = PanunoteQuestions::where('quiz_id',  $quiz->quiz_id)->count();
            $quizcount++;
        }

        return view('livewire.panunote-quizzes', ['quizzes' => $this->quiz_list]);
    }
}

<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use Livewire\Component;
use App\Models\PanunoteNotes;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteQuestions;
use App\Models\PanunoteAnswers;
use App\Models\PanunoteNoteLikes;
use App\Models\PanunoteNoteVisits;
use App\Models\PanunoteUsers;
use URL;
use GuzzleHttp\Promise;

class PanunoteNote extends Component
{
    public $finalquestions = [];
    public $finalanswers = [];
    public $quiztypes = [];

    public $finaldifficulty = [];

    public $notecontent;
    public $subject_id;
    public $note_id;
    public $notevalues;
    public $notevalues_text;
    public $saved = 0;
    
    protected $listeners = [
        'set:notevalues' => 'setnotevalues',
        'set:paraphrasetext' => 'paraphrase',
        'set:submit' => 'submit',
        'refreshComponent' => '$refresh'
    ];

    public $isPublic = false;

    public $paraphrasedtext;
    public $defaulttext;

    public $modal = false;

    public $quiztitle;

    public $isgenerated = false;

    public $generated_quizzes;

    public $notelikes_count;
    public $notevisits_count;

    protected $rules = [
        'quiztitle' => 'required',
    ];
    
    public $notetags;

    public $note_details;
    public $highlighted;

    public function replace(){
        
    }

    public function delete(){

        if(session("USER_ID") == $this->note_details->user_id){
            PanunoteNoteLikes::where('note_id', $this->note_id)->delete();
            PanunoteNoteVisits::where('note_id', $this->note_id)->delete();
            PanunoteNotes::where('note_id', $this->note_id)->delete();
    
            return redirect('/subjects/'.$this->subject_id);
        }

    }

    public function savegenerated(){

        $this->validate();
        
        $this->note_details = PanunoteNotes::where('note_id', $this->note_id)->first();

        $quiz = PanunoteQuizzes::create([
            'quiz_tags' => $this->note_details->note_tags,
            'note_id' => $this->note_id,
            'quiz_sharing' => 0,
            'quiz_title' => $this->quiztitle,
            'user_id' => session('USER_ID')
        ])->quiz_id;


        $count = 0;
        foreach(array_combine(array_column($this->finalquestions, 0), $this->finalanswers) as $question => $answer){

            $questioncreate = PanunoteQuestions::create([
                'quiz_id' => $quiz,
                'question_text' => $question,
                'question_type' => 2,
                'question_difficulty' => $this->finaldifficulty[$count]
            ])->question_id;

            PanunoteAnswers::create([
                'question_id' => $questioncreate,
                'is_right' => 1,
                'answer_text' => $answer,
                'answer_type' => 2,
                'is_disabled' => 0,
            ]);

            $count++;
        }


        $this->dispatchBrowserEvent('savedNote');
        //dd($this->finalquestions, $this->finalanswers);
    }
    


    public function paraphrase($paraphrasetext){

        $this->highlighted = $paraphrasetext;

        if(strlen($paraphrasetext) > 100){
            $this->dispatchBrowserEvent('limitparaerror');
        }else{
            $client = new \GuzzleHttp\Client();
            $bearer = 'Bearer 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';
            
            $response = $client->post('https://burubugyot-notesparaphrase.hf.space/api/predict/',
                [
                    'headers' => [  
                        'Authorization' => $bearer
                    ],
    
                    'body' => json_encode(
                    [
                        'data' => [$paraphrasetext]
                    ])
    
                ]
            );
    
            $this->defaulttext = $paraphrasetext;
            $this->paraphrasedtext = str_replace('paraphrasedoutput: ', '', json_decode($response->getBody()->getContents())->data);
            //dd(json_decode($response->getBody()->getContents())->data);
    
            $this->dispatchBrowserEvent('paraphrased');
        }

    }

    // public function changecontent(){
    //      $this->notecontent = "asdasdasd";
    //      $this->notevalues = "asdasdasd";

    //      $this->dispatchBrowserEvent('creatednote');
    // }

    public function setnotevalues($notevalues, $notevalues_text) 
    {
        $this->notevalues = $notevalues;
        $this->notevalues_text = $notevalues_text;
    }  

    public function mount($subject_id=null, $note_id=null)
	{
        $this->note_details = PanunoteNotes::where('note_id', $this->note_id)->first();
		$this->subject_id;

        //$subject = PanunoteSubjects::where('subject_id', $this->subject_id)->first();
        
        $subject = PanunoteSubjects::where('subject_id', $this->subject_id)->first();
        $this->note_details = PanunoteNotes::where('note_id', $this->note_id)->first();

        if(!is_null($this->note_details) && !is_null($subject)){
            if(session('USER_ID') != $this->note_details->user_id){
                if($this->note_details->note_sharing == 1 && $subject->subject_sharing == 1 && !empty(session('USER_ID'))){
    
                    $a = PanunoteUsers::where('user_id', $subject->user_id)->first('username');
                    return redirect()->to('/'.$a->username.'/subjects/'.$this->subject_id.'/'.$this->note_id);
    
                }elseif($this->note_details->note_sharing == 0 && $subject->subject_sharing == 1 && !empty(session('USER_ID'))){
                    dd("Private");
                }else{
                    abort(404);
                }
            }
        }else{
            abort(404);
        }

     
        $this->notetitle = $this->note_details->note_title;
        $this->notecontent = $this->note_details->note_content;

        //sharing
        $this->sharing = ($this->note_details->note_sharing == 0) ? false : true;

        $this->urlsharing = URL::current();

        if($this->sharing == "true"){
          $this->urlsharing = $this->urlsharing;
        }else{
          $this->urlsharing = "";
        }

        //favorite
        $like = PanunoteNoteLikes::where([
            ['note_id', $this->note_id],
            ['user_id', session('USER_ID')]
        ])->first();

        $this->isfavorite = (!is_null($like) && $like->note_like == 1) ? true : false;

        $this->notetags = $this->note_details->note_tags;

        $this->notelikes_count = PanunoteNoteLikes::where('note_id', $this->note_id)->where('note_like', 1)->count();
        $this->notevisits_count = PanunoteNoteVisits::where('note_id', $this->note_id)->count();
	}

    public function updateTag(){
        $this->note_details->note_tags = $this->notetags;
    }

    public function draft(){

        if(is_null($this->notevalues)){
           //dd($this->notecontent);
           $notefinalvalue = $this->notecontent;
        }else{
           //dd($this->notevalues);
           $notefinalvalue = $this->notevalues;
        }

        PanunoteNotes::where('note_id', $this->note_id)
        ->update([
            'note_title' => $this->notetitle,
            'note_content' => $notefinalvalue
        ]);

        $this->saved = 1;
    }


    public function sharingsetting(){
        $this->sharing = $this->sharing;

        PanunoteNotes::where('note_id', $this->note_id)
        ->update(['note_sharing' => ($this->sharing == "true") ? 1 : 0]);

        if($this->sharing == "true"){
            $this->urlsharing = URL::previous();
        }else{
            $this->urlsharing = "";
        }
    }

    public function like(){
        $this->isfavorite = !$this->isfavorite;

        $isexist = PanunoteNoteLikes::where([
            ['note_id', $this->note_id],
            ['user_id', session('USER_ID')]
        ])->exists();

        if($isexist){
            //update
            PanunoteNoteLikes::where('note_id', $this->note_id)
            ->where('user_id', session('USER_ID'))
            ->update(['note_like' => ($this->isfavorite) ? 1 : 0]);

        }else{
            //create
            PanunoteNoteLikes::create([
                'note_id' => $this->note_id,
                'user_id' => session('USER_ID'),
                'note_like' => ($this->isfavorite) ? 1 : 0
            ]);
        }
    }

    public function generate(){

        $matches = [];

        if(is_null($this->notevalues)){
            //dd($this->notecontent);
            $notefinalvalue = $this->notecontent;
         }else{
            //dd($this->notevalues);
            $notefinalvalue = $this->notevalues;
         }

         $str = $notefinalvalue;

         $del_re = '/<img\s[^>]*?src\s*=\s*[\'\"]([^\'\"]*?)[\'\"][^>]*?>/m';

         $str = preg_replace($del_re, '', $str);
    
         $re = '/<\s*span.+?style\s*=\s*"\s*background-color: rgb\(241, 196, 15\);\s*".*?>\s*([A-Za-z0-9_@ .\/{}()\],*+!~"\'#$%&:;?=[-]+)\s*<\/span>/';
         
         preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

        //  $check = [];
        // foreach($matches as $match){
        //     $check[] = $match[1];
        // }
         //dd(str_replace(' ', '', trim(implode('', $check))), str_replace(' ', '', preg_replace("/[\n\r]/", "", trim(str_replace("&nbsp;", " ", Strip_tags($notefinalvalue))))));

         if(count($matches) > 5){
            $this->dispatchBrowserEvent('limiterror');
         }else{
            if(empty($matches)){
                $this->dispatchBrowserEvent('emptyanswer');
             }else{
                // Print the entire match result
                //dd($matches[0]);
    
                $count = 0;
        
                $client = new \GuzzleHttp\Client();
                $bearer = 'Bearer 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';
                $sanitizehtml = str_replace("&nbsp;", " ", Strip_tags($notefinalvalue));
    
                //better 14secs on 5 questions
    
                    $promises = [];
    
                    foreach($matches as $answer){
                        
                        $promise = $client->postAsync('https://burubugyot-question-generation-two.hf.space/api/predict/',
                                        [
                                            'headers' => [  
                                                'Authorization' => $bearer
                                            ],
    
                                            'body' => json_encode(
                                            [  
                                                'data' => [
                                                    $sanitizehtml, 
                                                    str_replace("&nbsp;", " ", $answer[1])
                                                ]
                                            ]
    
                                        )]
                                    );
                        
                        array_push($promises, $promise);
    
                        $this->finalanswers[$count] = str_replace("&nbsp;", " ", $answer[1]);
                        $count++;
                    }
    
                    $results = Promise\Utils::all($promises)->wait();
    
                    $count = 0;
    
                    foreach ($results as $result) {
                        $this->finalquestions[$count] = json_decode($result->getBody()->getContents())->data;
                        $count++;
                    }
                
                    // dd($this->finalquestions);
                
                
                    //longer 22secs on 5 questions
    
                    //  foreach($matches as $answer){
                    
                    //     $response = $client->post('https://burubugyot-question-generation.hf.space/api/predict/',
                    //         [
                    //             'headers' => [  
                    //                 'Authorization' => $bearer
                    //             ],
    
                    //             'body' => json_encode(
                    //             [  
                    //                 'data' => [$sanitizehtml.'\n', str_replace("&nbsp;", " ", $answer[1])]
                    //             ]
    
                    //         )]
                    //     );
                        
                    //     $this->finalquestions[$count] = json_decode($response->getBody()->getContents())->data;
                    //     $this->finalanswers[$count] = str_replace("&nbsp;", " ", $answer[1]);
    
                    //     $count++;
                    //  }
    
    
                    //  dd($this->finalquestions);
    
    
                
    
                $count = 0;
                $frequency = [];
    
                foreach(array_column($this->finalquestions, 0) as $difficulty){
                
                    if($count == count($this->finalquestions)){
                        $difficulty = str_replace('?', '', $difficulty);
                    }
    
                    $frequency[$count]['total'] = 0;
                    $frequency[$count]['noofword'] = count(explode(' ', $difficulty));
    
                    foreach(explode(' ', $difficulty) as $diff){
                
                        $response = $client->get('https://api.datamuse.com/words?sp='.$diff.'&md=f&max=1');
                        $response_body = (string)$response->getBody();
                        
                        if(!empty(json_decode($response_body, true))){
                            //$frequency[$count]['total'] += str_replace('f:', '', json_decode($response_body, true)[0]['tags'][0]);
    
                            if(str_replace('f:', '', json_decode($response_body, true)[0]['tags'][0]) > 100){
                                $frequency[$count]['total'] += 2;
                            }elseif(str_replace('f:', '', json_decode($response_body, true)[0]['tags'][0]) <= 100 && str_replace('f:', '', json_decode($response_body, true)[0]['tags'][0]) > 50){
                                $frequency[$count]['total'] += 4;
                            }elseif(str_replace('f:', '', json_decode($response_body, true)[0]['tags'][0]) <= 50){
                                $frequency[$count]['total'] += 6;
                            }
    
                        }
                        
                    }
    
                    $count++;
                }
    
            
                // $test = [];
    
                // foreach($frequency as $fqncy){
                //     $test[] = $fqncy['total'] / $fqncy['noofword'] / $fqncy['noofword'];
                // }
    
                // dd($frequency, $test);
    
                //method 1
    
                // $count = 0;
                // foreach($frequency as $fqncy){
                //     if($fqncy['total'] <= 20){
                //         $this->finaldifficulty[$count] = "1";
                //     }elseif($fqncy['total'] > 20 && $fqncy['total'] <= 30){
                //         $this->finaldifficulty[$count] = "2";
                //     }elseif($fqncy['total'] > 30){
                //         $this->finaldifficulty[$count] = "3";
                //     }
    
                //     $count++;
                // }
    
    
                //method 2
    
    
    
                $count = 0;
                foreach($frequency as $fqncy){
                    if($fqncy['total'] / $fqncy['noofword'] < 2.5){
                        $this->finaldifficulty[$count] = "1";
                    }elseif($fqncy['total'] / $fqncy['noofword'] >= 2.5 && $fqncy['total'] / $fqncy['noofword'] < 3.5){
                        $this->finaldifficulty[$count] = "2";
                    }elseif($fqncy['total'] / $fqncy['noofword'] >= 3.5){
                        $this->finaldifficulty[$count] = "3";
                    }
    
                    $count++;
                }
    
    
    
                //dd($this->finalquestions, $this->finalanswers, $this->finaldifficulty);
    
    
    
                $this->dispatchBrowserEvent('generated');
                $this->isgenerated = true;
                //dd($questions, $answers);
             }
         }



 
    }
    

    public function submit(){

        $this->dispatchBrowserEvent('notesaved');

        if(is_null($this->notevalues)){
            //dd($this->notecontent);
            $notefinalvalue = $this->notecontent;
         }else{
            //dd($this->notevalues);
            $notefinalvalue = $this->notevalues;
         }
 
         $a = PanunoteNotes::where('note_id', $this->note_id)
         ->update([
             'note_tags' => $this->notetags,
             'note_title' => $this->notetitle,
             'note_content' => $notefinalvalue
         ]);


        $this->updateTag();
        $this->saved = 1;
    }


    public function render()
    {

        $subject = PanunoteSubjects::where('subject_id', $this->subject_id)->first();

            
            $this->generated_quizzes = PanunoteQuizzes::where('note_id', $this->note_id)->get();

            $count = 0;
            foreach($this->generated_quizzes as $note){
                $this->generated_quizzes[$count]['items'] = PanunoteQuestions::where('quiz_id', $note->quiz_id)->count();
                $count++;
            }

            return view('livewire.panunote-note', ['subject_details' => $subject]);
        
    }


}

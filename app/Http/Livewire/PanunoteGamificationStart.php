<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PanunoteGamificationRoom;
use App\Models\PanunoteGamificationInroom;
use App\Models\PanunoteQuestions;
use App\Models\PanunoteAnswers;
use DB;
use Carbon\Carbon;
use App\Events\QuestionNext;
use App\Events\UserAnswer;
use App\Events\AdminLeaved;
use Session;

class PanunoteGamificationStart extends Component
{

    public $game_id;

    public $question_ends;
    public $current_end;
    public $current_count = 0;
    public $current_start;
    public $ended = false;
    public $current_question;
    public $questions;

    public $current_answers;
    public $answers = [];
    
    public $multipleanswer = [];
    public $user_answer;

    public $playerdetails;

    protected $listeners = [
        'nextquestion' => 'list_nextquestion',
        'questionnexted' => 'list_questionnexted',
        'postquestion' => 'list_postquestion',
        'useranswered' => 'list_useranswered',
        'reloaded' => 'list_reloaded',
        'adminleaves' => 'list_adminleaves',
    ];

    public function list_adminleaves($room_id){

        if($room_id == $this->game_id){
         
            $a = PanunoteGamificationInroom::where(function ($query) {
                $query->where('role', '!=', 1)
                    ->where('game_id', $this->game_id)
                    ->where('user_status', '<=', 1)
                    ->oldest('created_at');
            })->first();

           
                if($a->user_id == session('USER_ID')){
                    PanunoteGamificationInroom::where('game_id', $this->game_id)
                    ->where('user_id', $a->user_id)
                    ->update(['role'=> 1]);
    
                    $this->dispatchBrowserEvent('notify');
    
                    //get role
                    $this->yourrole = DB::table('panunote_gamification_room')
                    ->join('panunote_gamification_inroom', 'panunote_gamification_room.game_id', '=', 'panunote_gamification_inroom.game_id')
                    ->where('panunote_gamification_room.game_id', $this->game_id)
                    ->where('panunote_gamification_inroom.user_id', session('USER_ID'))
                    ->first()->role;

                    $this->playerdetails = PanunoteGamificationInroom::select('panunote_gamification_inroom.role', 'panunote_gamification_inroom.refreshToken', 'panunote_gamification_inroom.user_status', 'panunote_gamification_inroom.user_id', 'panunote_gamification_inroom.score', 'panunote_users.username')
                    ->where('game_id', '=', $this->game_id)
                    ->join('panunote_users', 'panunote_gamification_inroom.user_id', '=', 'panunote_users.user_id')
                    ->orderBy('score', 'DESC')->get()->toArray();
                }
            

        }

    }

    public function list_reloaded(){
        return redirect()->to('/lobby/'.$this->game_id);
    }

    public function list_useranswered(){
        //player scores
        $this->playerdetails = PanunoteGamificationInroom::select('panunote_gamification_inroom.role', 'panunote_gamification_inroom.refreshToken', 'panunote_gamification_inroom.user_status', 'panunote_gamification_inroom.user_id', 'panunote_gamification_inroom.score', 'panunote_users.username')
        ->where('game_id', '=', $this->game_id)
        ->join('panunote_users', 'panunote_gamification_inroom.user_id', '=', 'panunote_users.user_id')
        ->orderBy('score', 'DESC')->get()->toArray();

    }

    public function list_questionnexted($room_id){
        if($room_id == $this->game_id){
            // $count = 0;
            // foreach($this->playerdetails as $players){
            //     $this->playerdetails[$count]['user_status'] = 0;
            //     $count++;
            // };

            //player scores
            $this->playerdetails = PanunoteGamificationInroom::select('panunote_gamification_inroom.role', 'panunote_gamification_inroom.refreshToken', 'panunote_gamification_inroom.user_status', 'panunote_gamification_inroom.user_id', 'panunote_gamification_inroom.score', 'panunote_users.username')
            ->where('game_id', '=', $this->game_id)
            ->join('panunote_users', 'panunote_gamification_inroom.user_id', '=', 'panunote_users.user_id')
            ->orderBy('score', 'DESC')->get()->toArray();


            $this->ended = false;
            $this->next = false;

            // $this->current_start = Carbon::now('Asia/Manila');
            $this->current_count++;
            $this->current_end = Carbon::now('Asia/Manila')->addSeconds($this->timePeritem + 5);

   
            $this->current_question = $this->questions[$this->current_count];
            $this->current_answers = $this->answers[$this->current_count];

            //get new right answer
            $a = [];
            
            foreach($this->current_answers as $ans){
                if($ans['is_right'] == 1){
                   $a[] = $ans['answer_text'];
                }
            }
            $this->rightanswer = $a;



            $this->dispatchBrowserEvent('updated_question');

        }
    }

    public $finished = false;

    public function list_postquestion(){
        $this->ended = true;
    }

    //next button
    public function list_nextquestion(){
        
        //game ended
        if($this->current_count == $this->roomdetails->item_count-1){

            PanunoteGamificationInroom::where('game_id', $this->game_id)
            ->where('user_id', session('USER_ID'))
            ->update(['user_status'=>'1']);

            $this->playerdetails = PanunoteGamificationInroom::select('panunote_gamification_inroom.role', 'panunote_gamification_inroom.refreshToken', 'panunote_gamification_inroom.user_status', 'panunote_gamification_inroom.user_id', 'panunote_gamification_inroom.score', 'panunote_users.username')
            ->where('game_id', '=', $this->game_id)
            ->join('panunote_users', 'panunote_gamification_inroom.user_id', '=', 'panunote_users.user_id')
            ->orderBy('score', 'DESC')->get()->toArray();


            if($this->yourrole == 1){
                // event(new UserAnswer());

                PanunoteGamificationRoom::where('game_id', $this->game_id)->update([
                    'status'=>3,
                ]);
            }

            $this->finished = true;
            $this->next = true;
            $this->ended = true;

            //if user is answered make its status to "PAUSE" if the time is done or admin clicked next chnage status to "CONTINUE";
            // PanunoteGamificationInroom::where('user_id', session('USER_ID'))
            // ->where('game_id', $this->game_id)
            // ->update(['user_status'=>'1']);

        }else{

            // if($this->yourrole == 1){
            //     event(new UserAnswer());
            // }

            PanunoteGamificationInroom::where('game_id', $this->game_id)
            ->where('user_id', session('USER_ID'))
            ->update(['user_status'=>'1']);

            $this->playerdetails = PanunoteGamificationInroom::select('panunote_gamification_inroom.role', 'panunote_gamification_inroom.refreshToken', 'panunote_gamification_inroom.user_status', 'panunote_gamification_inroom.user_id', 'panunote_gamification_inroom.score', 'panunote_users.username')
            ->where('game_id', '=', $this->game_id)
            ->join('panunote_users', 'panunote_gamification_inroom.user_id', '=', 'panunote_users.user_id')
            ->orderBy('score', 'DESC')->get()->toArray();



            $this->next = true;
            $this->ended = true;
        }

    }

    public function next_question(){
            //event next
            PanunoteGamificationInroom::where('game_id', $this->game_id)
            ->where('user_status', 1)
            ->update(['user_status'=>'0']);

            PanunoteGamificationRoom::where('game_id', $this->game_id)->update([
                'game_start' => Carbon::now('Asia/Manila')->toTimeString(),
                'current_count' => $this->current_count,
                'game_ends' => $this->current_end->toTimeString()
            ]);

            event(new QuestionNext($this->game_id));

    }

    public function mount($game_id=null){
        
        $this->roomdetails = PanunoteGamificationRoom::where('game_id', '=', $this->game_id)->first();

        //if user refreshed
        PanunoteGamificationInroom::where('user_id', session('USER_ID'))
        ->where('game_id', $this->game_id)
        ->increment('refreshToken');


        //check if user is joined
        $this->isjoined = DB::table('panunote_gamification_room')
        ->join('panunote_gamification_inroom', 'panunote_gamification_room.game_id', '=', 'panunote_gamification_inroom.game_id')
        ->where('panunote_gamification_room.game_id', $this->game_id)
        ->where('panunote_gamification_inroom.user_id', session('USER_ID'))
        ->exists();

        if(!$this->isjoined){
            abort(404);
        }
        

        //get role
        $this->yourrole = DB::table('panunote_gamification_room')
        ->join('panunote_gamification_inroom', 'panunote_gamification_room.game_id', '=', 'panunote_gamification_inroom.game_id')
        ->where('panunote_gamification_room.game_id', $this->game_id)
        ->where('panunote_gamification_inroom.user_id', session('USER_ID'))
        ->first()->role;
        

        //user details
        $this->userdetails = PanunoteGamificationInroom::where('user_id', '=', session('USER_ID'))
        ->where('game_id', $this->game_id)
        ->first();

        //for leavers
        if($this->userdetails->user_status == 2 && $this->roomdetails->status != 3){
            abort(404);
        }
        elseif($this->userdetails->user_status == 2 && $this->roomdetails->status == 3){
            $this->finished = true;
            $this->next = true;
            $this->ended = true;
        }

        
        if($this->roomdetails->status != 3 && $this->userdetails->refreshToken > 1 && ($this->userdetails->user_status == 0 || $this->userdetails->user_status == 1)){
            if($this->yourrole == 1){
        
                $a = PanunoteGamificationInroom::where(function ($query) {
                    $query->where('role', '!=', 1)
                        ->where('game_id', $this->game_id)
                        ->where('user_status', '<=', 1)
                        ->oldest('created_at');
                })->first();

                if(!is_null($a)){
                    event(new AdminLeaved($this->game_id));
                }else{
                    PanunoteGamificationRoom::where('game_id', $this->game_id)->update(['status'=> 3]);
                }

                
            }
            
            if($this->roomdetails->status != 3){

                PanunoteGamificationInroom::where('user_id', session('USER_ID'))
                ->where('game_id', $this->game_id)
                ->update(['user_status'=> 2]);

                abort(404);
            }else{
                $this->finished = true;
                $this->next = true;
                $this->ended = true;
            }

            
        }
            //PanunoteGamificationInroom::where('user_id', session('USER_ID'))->delete();
        elseif($this->roomdetails->status == 3){
            $this->finished = true;
            $this->next = true;
            $this->ended = true;
        }

        // if($this->userdetails->user_status == 0){
        //     $this->ended = false;
        // }else{
        //     $this->ended = true;
        //     if($this->roomdetails->status == 3){
        //         $this->next = true;
        //         $this->finished = true;
        //     }else{
        //         $this->next = true;
        //     }
        // }


        //player scores
        $this->playerdetails = PanunoteGamificationInroom::select('panunote_gamification_inroom.role', 'panunote_gamification_inroom.refreshToken', 'panunote_gamification_inroom.user_status', 'panunote_gamification_inroom.user_id', 'panunote_gamification_inroom.score', 'panunote_users.username')
        ->where('game_id', '=', $this->game_id)
        ->join('panunote_users', 'panunote_gamification_inroom.user_id', '=', 'panunote_users.user_id')
        ->orderBy('score', 'DESC')->get()->toArray();

 
        //room details
        $this->current_count = (is_null($this->roomdetails->current_count)) ? 0 : $this->roomdetails->current_count;
        $this->current_start = Carbon::now('Asia/Manila');
        $this->current_end = Carbon::parse($this->roomdetails->game_ends)->addSeconds(5);

        //questions
        $this->questions = PanunoteQuestions::where('quiz_id', '=', $this->roomdetails->quiz_id)->get()->toArray();
        $this->current_question = $this->questions[$this->roomdetails->current_count];

        //answers
        foreach($this->questions as $question_id){
            $this->answers[] = PanunoteAnswers::where('question_id', '=', $question_id)->get()->toArray();
        }
        $this->current_answers = $this->answers[$this->roomdetails->current_count];

        foreach($this->current_answers as $ans){
            if($ans['is_right'] == 1){
                $this->rightanswer = [$ans['answer_text']];
            }
        }

        switch ($this->roomdetails->time) {
            case 0:
              $this->timePeritem = 20;
              break;
            case 1:
              $this->timePeritem = 40;
              break;
            case 2:
              $this->timePeritem = 60;
              break;
            default:
              dd("Something Went Wrong");
        }

        if($this->roomdetails->status == 0){
            return redirect()->to('/lobby/'.$this->game_id);
        }
        
    }


    public $diff = 0;
    public $stoppolling = true;
    public $test = [];
    public $next = false;
    public $userdetails;
    public $auto_next = false;
    public $timePeritem;

    public $useranswer;
    public $rightanswer = [];
    

    public function user_answer($useranswer){
        //get answer for multiple choice only
        $this->ended = true;
        $this->useranswer = $useranswer;


        //multiple choice
        if(count($this->rightanswer) == 1 && $this->current_question['question_type'] == 1){

            if(strtolower(str_replace(' ','',$this->useranswer)) == strtolower(str_replace(' ','',$this->rightanswer[0]))){
                $iscorrect = true;
            }else{
                $iscorrect = false;
            }

        //multiple answer
        }elseif(count($this->rightanswer) > 1 && $this->current_question['question_type'] == 1){

            $answer_bool = true;
            $answer_count = 0;

            foreach($this->multipleanswer as $ans){
                if(!in_array($ans, $this->rightanswer)){
                    $answer_bool = false;
                }
                $answer_count++;
            }

            if($answer_bool && $answer_count == count($this->rightanswer)){
                $iscorrect = true;
            }else{
                $iscorrect = false;
            }

        //identification
        }else{
            if(strtolower(str_replace(' ','',$this->user_answer)) == strtolower(str_replace(' ','',$this->rightanswer[0]))){
                $iscorrect = true;
            }else{
                $iscorrect = false;
            }
        }

        if($iscorrect){

            $this->diff += Carbon::now('Asia/Manila')->diffInMilliseconds($this->current_end, false);
            // $this->test[] = Carbon::now('Asia/Manila')->toTimeString()  . " / " . $this->roomdetails->game_ends;
    
            if($this->diff < 0){
                $this->diff = 0;
            }
    
             //if user is answered make its status to "PAUSE" if the time is done or admin clicked next chnage status to "CONTINUE";
            PanunoteGamificationInroom::where('user_id', session('USER_ID'))
            ->where('game_id', $this->game_id)
            ->update(['user_status'=>'1', 'score'=>$this->diff]);
    
            // $this->ended = true;

        }else{

            $this->diff += 0;

            //if user is answered make its status to "PAUSE" if the time is done or admin clicked next chnage status to "CONTINUE";
            PanunoteGamificationInroom::where('user_id', session('USER_ID'))
            ->where('game_id', $this->game_id)
            ->update(['user_status'=>'1', 'score'=>$this->diff]);
    
            // $this->ended = true;

        }

        $this->playerdetails = PanunoteGamificationInroom::select('panunote_gamification_inroom.role', 'panunote_gamification_inroom.refreshToken', 'panunote_gamification_inroom.user_status', 'panunote_gamification_inroom.user_id', 'panunote_gamification_inroom.score', 'panunote_users.username')
        ->where('game_id', '=', $this->game_id)
        ->join('panunote_users', 'panunote_gamification_inroom.user_id', '=', 'panunote_users.user_id')
        ->orderBy('score', 'DESC')->get()->toArray();


        // event(new UserAnswer());
    }



    public function render()
    {
        //get players
        $user_ids = PanunoteGamificationInroom::select('user_id')
        ->pluck('user_id');

        //get players info
        $this->players = DB::table('panunote_users')
        ->whereIn('user_id', $user_ids)->get();


        if($this->isjoined){
            return view('livewire.panunote-gamification-start', ['players' => $this->players])->layout('layouts.gamebase');
        }else{
            abort(404);
        }

    }
}

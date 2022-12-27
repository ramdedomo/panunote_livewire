<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteGamificationRoom;
use App\Models\PanunoteGamificationInroom;
use App\Models\PanunoteQuestions;
use Illuminate\Support\Facades\Hash;
use App\Events\RoomCreate;
use App\Events\AdminLeaved;
use App\Events\PlayerAdminize;

class PanunoteGamificationCreate extends Component
{
    public $rooms = [];
    public $playercount = [];
    public $itemscount = [];

    // public $isjoined = false;
    public $alreadyjoinedid;

    public $quiz_list;

    public $createDescription;
    public $isPublic;
    public $privatePass;
    public $quizSelect;
    public $timeSelect;
    public $capaSelect;

    public $isReadonly;

    public $joinprivateid;
    public $joinprivatepassword;

    public $joinmanualid;
    public $joinmanualpassword;

    public function mount(){

        $leave = PanunoteGamificationInroom::where('panunote_gamification_inroom.user_id', session('USER_ID'))
        ->join('panunote_gamification_room', 'panunote_gamification_inroom.game_id', '=', 'panunote_gamification_room.game_id')
        ->where('panunote_gamification_room.status', "<", 3);

        if($leave->exists()){
            $gameid = $leave->first()->game_id;
            if($leave->first()->role == 1){
                $b = PanunoteGamificationInroom::where('role', '!=', 1)
                          ->where('game_id', $leave->first()->game_id)
                          ->oldest('created_at')
                          ->first();

                if(!is_null($b)){
                    PanunoteGamificationInroom::where('game_id', $leave->first()->game_id)
                    ->where('user_id', $b->user_id)
                    ->update(['role'=> 1]);

                    PanunoteGamificationRoom::where('game_id', $leave->first()->game_id)->decrement('player_count');
                    $leave->delete();

                    event(new PlayerAdminize($b->user_id));
                }else{
                    $leave->delete();
                    PanunoteGamificationRoom::where('game_id', $gameid)->delete();
                }

            }else{
                PanunoteGamificationRoom::where('game_id', $leave->first()->game_id)->decrement('player_count');
                $leave->delete();
            }
        }

        
        // $a = PanunoteGamificationInroom::where('panunote_gamification_inroom.user_id', session('USER_ID'))
        // ->join('panunote_gamification_room', 'panunote_gamification_inroom.game_id', '=', 'panunote_gamification_room.game_id')
        // ->where('panunote_gamification_room.status', "<", 3);
        
        // if($a->exists()){
        //     PanunoteGamificationRoom::where('game_id', $a->first()->game_id)->decrement('player_count');
        //     $a->delete();
        // }

        // //check if user is already joined
        // $this->isjoined = DB::table('panunote_gamification_room')
        // ->join('panunote_gamification_inroom', 'panunote_gamification_room.game_id', '=', 'panunote_gamification_inroom.game_id')
        // ->where('panunote_gamification_inroom.user_id', session('USER_ID'))
        // ->where(function($q) {
        //     $q->where('panunote_gamification_room.status', 0)
        //       ->orWhere('panunote_gamification_room.status', 1)
        //       ->orWhere('panunote_gamification_room.status', 2);
        // })
        // ->exists();

        // //if player is already joined a game
        // if($this->isjoined){
        //     $getexist = DB::table('panunote_gamification_room')
        //     ->join('panunote_gamification_inroom', 'panunote_gamification_room.game_id', '=', 'panunote_gamification_inroom.game_id')
        //     ->where('panunote_gamification_inroom.user_id', session('USER_ID'))
        //     ->where(function($q) {
        //         $q->where('panunote_gamification_room.status', 0)
        //           ->orWhere('panunote_gamification_room.status', 1)
        //           ->orWhere('panunote_gamification_room.status', 2);
        //     })
        //     ->first();

        //     $this->alreadyjoinedid = $getexist->game_id;
        // }
        
        //get all quizzess
        $this->quiz_list = DB::table('panunote_quizzes')
        ->where('user_id', session('USER_ID'))
        ->get()
        ->toArray();

        $count = 0;
        foreach($this->quiz_list as $list){
            if(!PanunoteQuestions::where('quiz_id', $list->quiz_id)->exists()){
                unset($this->quiz_list[$count]);
            }
            $count++;
        }
        

        if(!empty($this->quiz_list)){
            $this->quizSelect = $this->quiz_list[0]->quiz_id;
        }


        $this->timeSelect = 0;
        $this->diffSelect = 0;
        $this->capaSelect = 0;

        $this->isPublic = true;
        $this->isReadonly = true;
    }

    protected $rules = [
        'createDescription' => 'required|min:6',
        'privatePass' => 'required_if:isPublic,==,false',
    ];

    public function create(){
        $this->validate();

        // dd($this->createDescription,
        // $this->isPublic,
        // $this->privatePass,
        // $this->quizSelect,
        // $this->timeSelect,
        // $this->capaSelect,
        // $this->diffSelect);

        $count = PanunoteQuestions::where('quiz_id', '=', $this->quizSelect)->get()->count();

        $createdroom = PanunoteGamificationRoom::create([
            'quiz_id' => $this->quizSelect,
            'game_capacity' => $this->capaSelect,
            'status' => 0,
            "is_private" => !$this->isPublic,
            "password" => (!$this->isPublic) ? Hash::make($this->privatePass) : null,
            "game_description" => $this->createDescription,
            "game_difficulty" => $this->diffSelect,
            "time" => $this->timeSelect,
            "player_count" => 1,
            "item_count" => $count

        ])->game_id;

        
        PanunoteGamificationInroom::create([
            'user_id' => session('USER_ID'),
            'game_id' => $createdroom,
            'role' => 1,
        ]);


        event(new RoomCreate());
        return redirect('lobby/'.$createdroom);
    }

    public function isPublic(){
        if($this->isPublic){
            $this->isReadonly = true;
        }else{
            $this->isReadonly = false;
        }
    }

    public function render()
    {
        $count = 0;
        foreach($this->quiz_list as $list){
            if(!PanunoteQuestions::where('quiz_id', $list->quiz_id)->exists()){
                unset($this->quiz_list[$count]);
            }
            $count++;
        }

        return view('livewire.panunote-gamification-create', ["quiz_list" => $this->quiz_list])->layout('layouts.gamebase');
    }

    // public function rejoin($id){
    //     //dd($id);
    //     return redirect('lobby/'.$id);
    // }
}

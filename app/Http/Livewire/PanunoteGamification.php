<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteGamificationRoom;
use App\Models\PanunoteGamificationInroom;
use Illuminate\Support\Facades\Hash;

class PanunoteGamification extends Component
{
    public $rooms = [];
    public $playercount = [];
    public $itemscount = [];

    public $isjoined = false;
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
        //check if user is already joined
        $this->isjoined = DB::table('panunote_gamification_room')
        ->join('panunote_gamification_inroom', 'panunote_gamification_room.game_id', '=', 'panunote_gamification_inroom.game_id')
        ->where('panunote_gamification_inroom.user_id', session('USER_ID'))
        ->where(function($q) {
            $q->where('panunote_gamification_room.status', 0)
              ->orWhere('panunote_gamification_room.status', 1)
              ->orWhere('panunote_gamification_room.status', 2);
        })
        ->exists();

        //if player is already joined a game
        if($this->isjoined){
            $getexist = DB::table('panunote_gamification_room')
            ->join('panunote_gamification_inroom', 'panunote_gamification_room.game_id', '=', 'panunote_gamification_inroom.game_id')
            ->where('panunote_gamification_inroom.user_id', session('USER_ID'))
            ->where(function($q) {
                $q->where('panunote_gamification_room.status', 0)
                  ->orWhere('panunote_gamification_room.status', 1)
                  ->orWhere('panunote_gamification_room.status', 2);
            })
            ->first();

            $this->alreadyjoinedid = $getexist->game_id;
        }
        
        //get all quizzess
        $this->quiz_list = DB::table('panunote_quizzes')
        ->get()->toArray();

        //get rooms
        $this->rooms = DB::table('panunote_gamification_room')
        ->get()->toArray();

        //playercount
        foreach($this->rooms as $room){
            $a = DB::table('panunote_gamification_inroom')
                ->where('game_id', $room->game_id)
                ->count();

            $this->playercount[$room->game_id] = $a;
        }

        //itemscount
        foreach($this->rooms as $room){
            $a = DB::table('panunote_questions')
                ->where('quiz_id', $room->quiz_id)
                ->count();

            $this->itemscount[$room->game_id] = $a;
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

        $createdroom = PanunoteGamificationRoom::create([
            'quiz_id' => $this->quizSelect,
            'game_capacity' => $this->capaSelect,
            'status' => 0,
            "is_private" => !$this->isPublic,
            "password" => (!$this->isPublic) ? Hash::make($this->privatePass) : null,
            "game_description" => $this->createDescription,
            "game_difficulty" => $this->diffSelect,
            "time" => $this->timeSelect
        ])->game_id;

        
        PanunoteGamificationInroom::create([
            'user_id' => session('USER_ID'),
            'game_id' => $createdroom,
            'role' => 1,
        ]);


        return redirect('thegame/'.$createdroom);
    }

    public function isPublic(){
        if($this->isPublic){
            $this->isReadonly = true;
        }else{
            $this->isReadonly = false;
        }
    }

    public function refreshrooms(){
        //get all quizzess
        $this->quiz_list = DB::table('panunote_quizzes')
        ->get()->toArray();

        //get rooms
        $this->rooms = DB::table('panunote_gamification_room')
        ->get()->toArray();

        //playercount
        foreach($this->rooms as $room){
            $a = DB::table('panunote_gamification_inroom')
                ->where('game_id', $room->game_id)
                ->count();

            $this->playercount[$room->game_id] = $a;
        }

        //itemscount
        foreach($this->rooms as $room){
            $a = DB::table('panunote_questions')
                ->where('quiz_id', $room->quiz_id)
                ->count();

            $this->itemscount[$room->game_id] = $a;
        }
    }

    public function rejoin($id){
        //dd($id);
        return redirect('thegame/'.$id);
    }

    public function join($id){
        //dd($id);
        PanunoteGamificationInroom::create([
            'user_id' => session('USER_ID'),
            'game_id' => $id,
            'role' => 0,
        ]);

        return redirect('thegame/'.$id);
    }

    public function joinpriv($id){
        $this->joinprivateid = $id;
    }

    public function joinprivate($id){
        $this->validate([
            'joinprivatepassword' => 'required',
        ]);

        $password = PanunoteGamificationRoom::where('game_id', $id)->first();
        
        if(Hash::check($this->joinprivatepassword, $password->password)){
            PanunoteGamificationInroom::create([
                'user_id' => session('USER_ID'),
                'game_id' => $id,
                'role' => 0,
            ]);

            return redirect('thegame/'.$id);
        }else{
           dd("wrongpassword");
        }
 
    }

    public function joinmanual(){
        $this->validate([
            'joinmanualid' => 'required',
            'joinmanualpassword' => 'required',
        ]);

        $a = PanunoteGamificationRoom::where('game_id', $this->joinmanualid)->exists();
        
        if($a){
            $password = PanunoteGamificationRoom::where('game_id', $this->joinmanualid)->first();
            if(Hash::check($this->joinmanualpassword, $password->password)){
                
                PanunoteGamificationInroom::create([
                    'user_id' => session('USER_ID'),
                    'game_id' => $this->joinmanualid,
                    'role' => 0,
                ]);
    
                return redirect('thegame/'.$this->joinmanualid);

            }else{
                dd("wrong password");
            }
        }else{
            dd("Id not found");
        }

    }

    public function render()
    {
        //get all quizzess
        $this->quiz_list = DB::table('panunote_quizzes')
        ->get()->toArray();

        //get rooms
        $this->rooms = DB::table('panunote_gamification_room')
        ->get()->toArray();

        return view('livewire.panunote-gamification', ["quiz_list" => $this->quiz_list, "rooms" => $this->rooms])->layout('layouts.gamebase');
    }
}

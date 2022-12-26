<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteUsers;
use App\Models\PanunoteGamificationRoom;
use App\Models\PanunoteGamificationInroom;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use App\Events\PlayerJoin;
use App\Events\PlayerKick;
use App\Events\PlayerAdminize;

class PanunoteGamificationJoin extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $sample = [];
    public $sample2 = [];

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

    public $sorted = "item_count";


    protected $listeners = [
        'roomcreated' => '$refresh',
    ];
    
    public function getSelectval(){
        dd($this->sample);
    }

    public function sortId($sorted){
        if($sorted == 1){
            $this->sorted = 'player_count';
            $this->sortCount_bool = !$this->sortCount_bool;
        }elseif($sorted == 2){
            $this->sorted = 'item_count';
            $this->sortItem_bool = !$this->sortItem_bool;
        }

    }


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

            // if(!is_null($b)){
            //     PanunoteGamificationInroom::where('game_id', $a->first()->game_id)
            //     ->where('user_id', $b->user_id)
            //     ->update(['role'=> 1]);

            //     PanunoteGamificationRoom::where('game_id', $a->first()->game_id)->decrement('player_count');
            //     $a->delete();
            // }else{
            //     PanunoteGamificationRoom::where('game_id', $this->game_id)->update(['status'=> 3]);
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
        ->get()->toArray();

        //get rooms
        $this->rooms = DB::table('panunote_gamification_room')->get();

        // //playercount
        // foreach($this->rooms as $room){
        //     $a = DB::table('panunote_gamification_inroom')
        //         ->where('game_id', $room->game_id)
        //         ->count();

        //     $this->playercount[$room->game_id] = $a;
        // }

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


        return redirect('lobby/'.$createdroom);
    }

    public function isPublic(){
        if($this->isPublic){
            $this->isReadonly = true;
        }else{
            $this->isReadonly = false;
        }
    }


    // public function rejoin($id){
    //     //dd($id);
    //     return redirect('lobby/'.$id);
    // }

    public function join($id){
        //dd($id);
        if(PanunoteGamificationRoom::where('game_id', $id)->exists()){
            if(!PanunoteGamificationInroom::where('user_id', session('USER_ID'))->where('game_id', $id)->exists()){
                PanunoteGamificationInroom::create([
                    'user_id' => session('USER_ID'),
                    'game_id' => $id,
                    'role' => 0,
                ]);
    
                PanunoteGamificationRoom::find($id)->increment('player_count');
                $playerinfo = PanunoteUsers::where('user_id', session('USER_ID'))->first();
                event(new PlayerJoin($playerinfo->username));
                return redirect('lobby/'.$id);
            }else{
                return redirect('lobby/'.$id);
            }
        }else{
            $this->dispatchBrowserEvent('error');
        }
        

    }

    public function joinpriv($id){
        $this->joinprivateid = $id;
    }

    public function joinprivate($id){
        $this->validate([
            'joinprivatepassword' => 'required',
        ]);

        $password = PanunoteGamificationRoom::where('game_id', $id)->first();

        if(PanunoteGamificationRoom::where('game_id', $id)->exists()){
            if(!PanunoteGamificationInroom::where('user_id', session('USER_ID'))->where('game_id', $id)->exists()){
                if(Hash::check($this->joinprivatepassword, $password->password)){
                    PanunoteGamificationInroom::create([
                        'user_id' => session('USER_ID'),
                        'game_id' => $id,
                        'role' => 0,
                    ]);

                    PanunoteGamificationRoom::find($id)->increment('player_count');

                    return redirect('lobby/'.$id);
                }else{
                    $this->dispatchBrowserEvent('wrongcredentials');
                }
            }else{
                return redirect('lobby/'.$id);
            }
        }else{
            $this->dispatchBrowserEvent('error');
        }

 
    }

    public function joinmanual(){
        $this->validate([
            'joinmanualid' => 'required',
            'joinmanualpassword' => 'required',
        ]);

        $a = PanunoteGamificationRoom::where('game_id', $this->joinmanualid)->exists();
        
        if($a){
            if(!PanunoteGamificationInroom::where('user_id', session('USER_ID'))->where('game_id', $id)->exists()){
                $password = PanunoteGamificationRoom::where('game_id', $this->joinmanualid)->first();
                if(Hash::check($this->joinmanualpassword, $password->password)){
                    
                    PanunoteGamificationInroom::create([
                        'user_id' => session('USER_ID'),
                        'game_id' => $this->joinmanualid,
                        'role' => 0,
                    ]);

                    PanunoteGamificationRoom::find($this->joinmanualid)->increment('player_count');
                    return redirect('lobby/'.$this->joinmanualid);

                }else{
                    $this->dispatchBrowserEvent('wrongcredentials');
                }
            }else{
                return redirect('lobby/'.$id);
            }
        }else{
            $this->dispatchBrowserEvent('wrongcredentials');
        }

    }


    public $search;

    public $sortItem_val;
    public $sortCount_val;

    public $sortItem_bool;
    public $sortCount_bool;

    public $status = [];
    public $type;

    public function render()
    {
   
        if($this->sorted == 'player_count'){
            
            if($this->sortCount_bool){
                $a = 'DESC';
            }else{
                $a = 'ASC';
            }

        }elseif($this->sorted == 'item_count'){

            if($this->sortItem_bool){
                $a = 'DESC';
            }else{
                $a = 'ASC';
            }
        }

        //get all quizzess
        $this->quiz_list = DB::table('panunote_quizzes')
        ->get()->toArray();


        $this->rooms = PanunoteGamificationRoom::search($this->search)
        ->when(!empty($this->status), function ($query) {
            $query->whereIn('status', $this->status);
        })
        ->when(!empty($this->type), function ($query) {
            $query->whereIn('is_private', $this->type);
        })
        ->orderBy($this->sorted, $a)->Paginate(6);

        

        $links = $this->rooms->links();
        $this->rooms = collect($this->rooms->items());
    
        
        return view('livewire.panunote-gamification-join', ["links" => $links, "quiz_list" => $this->quiz_list, "rooms" => $this->rooms])->layout('layouts.gamebase');
    }
}

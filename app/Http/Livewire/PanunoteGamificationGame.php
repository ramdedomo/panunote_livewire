<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use App\Models\PanunoteGamificationRoom;
use App\Models\PanunoteGamificationInroom;
use Carbon\Carbon;
use App\Events\PlayerAdminize;
use App\Events\PlayerKick;
use App\Events\RoomStart;
use Session;
use App\Events\AdminLeaved;

class PanunoteGamificationGame extends Component
{
    public $game_id;
    public $isjoined;

    public $roomdetails;

    public $players;
    public $yourrole;

    public $default_role;
    public $isadmin;

    protected $listeners = [
        'playerjoined' => 'list_playerjoined',
        'playeradminized' => 'list_playeradminized',
        'playerkicked' => 'list_playerkicked',
        'roomstarted' => 'list_roomstarted'
    ];

  

    public function list_roomstarted($game_id){
        if($this->game_id == $game_id){
            return redirect()->to('/panugame/'.$this->game_id);
        }
    }

     public function list_playerkicked($user_id){
        if($user_id == session('USER_ID')){
            $this->dispatchBrowserEvent('kicked');
            Session::flash('kicked', 'kicked'); 
        }
    }

    public function list_playeradminized($user_id){
        if($user_id == session('USER_ID')){
            $this->dispatchBrowserEvent('notify');
            $this->isadmin = true;
        }

        //get role
        $this->yourrole = DB::table('panunote_gamification_room')
        ->join('panunote_gamification_inroom', 'panunote_gamification_room.game_id', '=', 'panunote_gamification_inroom.game_id')
        ->where('panunote_gamification_room.game_id', $this->game_id)
        ->where('panunote_gamification_inroom.user_id', session('USER_ID'))
        ->first()->role;
    }


    public function list_playerjoined($playername){
        $this->dispatchBrowserEvent('playerjoined', ['player_name' => $playername]);
    }

    public function start(){

        if($this->isadmin){
            event(new RoomStart($this->game_id));

            PanunoteGamificationInroom::where('game_id', $this->game_id)->update(['refreshToken' => 0]);

            $a = PanunoteGamificationRoom::where('game_id', '=', $this->game_id)->first();
            $start = Carbon::now('Asia/Manila');
            $timePeritem = 0;
    
            switch ($a->time) {
                case 0:
                  $timePeritem = 20;
                  break;
                case 1:
                  $timePeritem = 40;
                  break;
                case 2:
                  $timePeritem = 60;
                  break;
                default:
                  dd("Something Went Wrong");
              }
    
            //dd($start->toTimeString(), json_encode($endtime), json_decode(json_encode($endtime), true));
    
            PanunoteGamificationRoom::where('game_id', $this->game_id)->update(['status'=>'1', 'game_start'=>Carbon::now('Asia/Manila')->toTimeString(), 'game_ends'=>$start->addSeconds($timePeritem)->toTimeString()]);
            //$a = PanunoteGamificationRoom::where('game_id', '=', $this->game_id)->first();
              

        }else{
            $this->dispatchBrowserEvent('error');
        }

    }

    public function mount($game_id=null){

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

        $this->default_role = $this->yourrole;

        //get room details
        $this->roomdetails = PanunoteGamificationRoom::where('game_id', '=', $this->game_id)->first();

        // if($this->roomdetails->status == 1){
        //     return redirect()->to('/panugame/'.$this->game_id);
        // }elseif($this->roomdetails->status == 3){

        // }
        $user_info = PanunoteGamificationInroom::where('user_id', session('USER_ID'))
        ->where('game_id', '=', $this->game_id)
        ->first();
 
        if(!$this->isjoined){
            abort(404);
        }

        if($this->roomdetails->status == 1){
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
                        $id = $leave->first()->game_id;
                        PanunoteGamificationRoom::where('game_id', $leave->first()->game_id)->decrement('player_count');
                        $leave->delete();
                
                        event(new AdminLeaved($id));
                    }else{
                        $leave->delete();
                        PanunoteGamificationRoom::where('game_id', $gameid)->delete();
                    }
    
                }else{
                    PanunoteGamificationRoom::where('game_id', $leave->first()->game_id)->decrement('player_count');
                    $leave->delete();
                }
            }

            return redirect('panugame');
        }

        if($user_info->user_status == 2 || $user_info->refreshToken > 1){
            abort(404);
        }

        
        if(is_null(PanunoteGamificationInroom::where('user_id', session('USER_ID'))->where('game_id', $this->game_id)->first()->user_status)){
            PanunoteGamificationInroom::where('user_id', session('USER_ID'))->where('game_id', $this->game_id)->update([
                'user_status' => 0
            ]);
        }else{
            if($user_info->role == 1){
                $b = PanunoteGamificationInroom::where('role', '!=', 1)
                          ->where('game_id', $this->game_id)
                          ->oldest('created_at')
                          ->first();

                if(!is_null($b)){
                    PanunoteGamificationInroom::where('game_id', $this->game_id)
                    ->where('user_id', $b->user_id)
                    ->update(['role'=> 1]);

                    PanunoteGamificationRoom::where('game_id', $this->game_id)->decrement('player_count');
                    PanunoteGamificationInroom::where('user_id', session('USER_ID'))->where('game_id', $this->game_id)->delete();

                    event(new PlayerAdminize($b->user_id));

                    return redirect('/panugame/join');
                }else{
                    PanunoteGamificationInroom::where('user_id', session('USER_ID'))->where('game_id', $this->game_id)->delete();
                    PanunoteGamificationRoom::where('game_id', $this->game_id)->delete();

                    return redirect('/panugame/join');
                }

            }else{
                PanunoteGamificationRoom::where('game_id', $this->game_id)->decrement('player_count');
                PanunoteGamificationInroom::where('user_id', session('USER_ID'))->where('game_id', $this->game_id)->delete();

                return redirect('/panugame/join');
            }
        }

        if($this->yourrole == 1){
            $this->isadmin = true;
        }
            
        if($this->roomdetails->status == 3){
            return redirect()->to('/panugame/'.$this->game_id);
        }
    }

    public function adminize($user_id){
        $this->isadmin = false;

        if($this->yourrole == 1){
            PanunoteGamificationInroom::where('user_id',$user_id)->update(['role'=>'1']);
            PanunoteGamificationInroom::where('user_id',session('USER_ID'))->update(['role'=>'0']);
            $this->default_role = 0;

            //firing event pusher
            event(new PlayerAdminize($user_id));
        }
    }
    
    public function kick($user_id){
        if(!$this->isadmin){
            $this->dispatchBrowserEvent('error');
        }else{
            PanunoteGamificationInroom::where('user_id',$user_id)->delete();
            PanunoteGamificationRoom::find($this->game_id)->decrement('player_count');
            event(new PlayerKick($user_id));
        }
    }

    public function leave(){
        PanunoteGamificationInroom::where('user_id', session('USER_ID'))
        ->where('game_id', $this->game_id)
        ->delete();

        PanunoteGamificationRoom::find($this->game_id)->decrement('player_count');

        return redirect()->to('/panugame/join');
    }

    public function render()
    {

        $user_ids = PanunoteGamificationInroom::select('user_id')
        ->where(function ($query) {
            $query->where('user_status', '<=' , 1)
                  ->where('game_id', $this->game_id);
        })->pluck('user_id');

        //get players
        // $user_ids = PanunoteGamificationInroom::select('user_id')
        // ->where('game_id', $this->game_id)
        // ->pluck('user_id');

        // dd($user_ids);

        //get players info
        $this->players = DB::table('panunote_users')
        ->whereIn('user_id', $user_ids)->get();


        if($this->isjoined){
            return view('livewire.panunote-gamification-game', ['players' => $this->players])->layout('layouts.gamebase');
        }else{
            abort(404);
        }

    }
}

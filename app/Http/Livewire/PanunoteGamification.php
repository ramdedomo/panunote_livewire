<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteGamificationRoom;
use App\Models\PanunoteGamificationInroom;
use App\Models\PanunoteQuestions;
use App\Models\PanunoteUsers;
use Illuminate\Support\Facades\Hash;
use App\Events\RoomCreate;
use App\Events\AdminLeaved;
use App\Events\PlayerAdminize;
use Illuminate\Support\Facades\Auth;


class PanunoteGamification extends Component
{
    public $game;
    public $isjoined;

    public function mount(){

        $leave = PanunoteGamificationInroom::where('panunote_gamification_inroom.user_id', Auth::user()->user_id)
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

        $this->user = PanunoteUsers::where('user_id',  Auth::user()->user_id)->first();



        $this->game = PanunoteGamificationInroom::where('user_id', Auth::user()->user_id)
        ->join('panunote_gamification_room', 'panunote_gamification_inroom.game_id', '=', 'panunote_gamification_room.game_id')
        ->where('panunote_gamification_room.status', 3)
        ->get();

        $this->isjoined = PanunoteGamificationInroom::where('user_id', Auth::user()->user_id)
        ->join('panunote_gamification_room', 'panunote_gamification_inroom.game_id', '=', 'panunote_gamification_room.game_id')
        ->where('panunote_gamification_room.status', '<=', 1)
        ->exists();
    }

    public function render()
    {
        return view('livewire.panunote-gamification')->layout('layouts.gamebase');
    }
}

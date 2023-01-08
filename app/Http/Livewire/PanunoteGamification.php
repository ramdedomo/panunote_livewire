<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteGamificationRoom;
use App\Models\PanunoteGamificationInroom;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class PanunoteGamification extends Component
{
    public $game;
    public $isjoined;

    public function mount(){
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

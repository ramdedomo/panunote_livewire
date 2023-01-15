<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PanunoteLogs extends Component
{
    public $search;
    public $date;

    public function render()
    {
        $logs =  DB::table('panunote_activity_logs')
        ->where('user_id', Auth::user()->user_id)
        ->where('description', 'like', '%'.$this->search.'%')
        ->when(empty($this->search), function ($query) {
            $query->where('id', '>', 0);
        })
        ->when(!empty($this->date), function ($query) {
            $query->whereBetween('created_at', [Carbon::parse($this->date)->startOfDay(), Carbon::parse($this->date)->endOfDay()]);
        })
        ->orderBy('created_at', 'DESC')
        ->paginate(8);

        return view('livewire.panunote-logs', ['logs' => $logs]);
    }
}

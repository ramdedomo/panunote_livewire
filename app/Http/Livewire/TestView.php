<?php

namespace App\Http\Livewire;

use Livewire\Component;

class TestView extends Component
{
    public function render()
    {
        return view('livewire.test-view')->layout('layouts.panunote_master');
    }
}

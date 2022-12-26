<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\PanunoteSubjects as PanunoteSubject;
use App\Models\PanunoteNotes;
use Session;

class PanunoteSubjects extends Component
{
    public $subjecttitle;
    public $subjectsharing = false;
    public $search;

    public $sort = "";

    protected $rules = [
        'subjecttitle' => 'required',
    ];

    public function submit()
    {
        $sharing = 0;

        if($this->subjectsharing){
            $sharing = 1;
        }

        $this->validate();

        $addsubject = PanunoteSubject::create([
            'subject_name' => $this->subjecttitle,
            'subject_sharing' => $sharing,
            'user_id' => Session::get('USER_ID')
        ]);

        $this->dispatchBrowserEvent('createdsubject');
    }

    public function render()
    {

        // $subject_list = PanunoteSubject::where('panunote_subjects.user_id', session('USER_ID'))->get();
   
        // $count = 0;
        // foreach($subject_list as $subject){
        //     $subject_list[$count]['notes'] = PanunoteNotes::where('subject_id',  $subject->subject_id)->get();
        //     $count++;
        // }

        $this->subject_list = PanunoteSubject::searchall($this->search)
        ->where('user_id', session('USER_ID'))
        ->when(empty($this->search), function ($query) {
            $query->where('subject_id', '>', 0);
        })
        ->when(!empty($this->sort), function ($query) {
            if($this->sort == 'lto'){
                $query->orderBy('updated_at', 'DESC');
            }elseif($this->sort == 'otl'){
                $query->orderBy('updated_at', 'ASC');
            }elseif($this->sort == 'atz'){
                $query->orderBy('subject_name', 'ASC');
            }elseif($this->sort == 'zta'){
                $query->orderBy('subject_name', 'DESC');
            }
        })
        ->get();
        
        $count = 0;
        foreach($this->subject_list as $subject){
            $this->subject_list[$count]['notes'] = PanunoteNotes::where('subject_id',  $subject->subject_id)->get();
            $count++;
        }

        return view('livewire.panunote-subjects', ['subjects' => $this->subject_list]);
    }
}

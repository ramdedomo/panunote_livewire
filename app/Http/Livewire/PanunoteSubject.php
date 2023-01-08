<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Session;
use App\Models\PanunoteNotes;
use App\Models\PanunoteNoteLikes;
use App\Models\PanunoteNoteVisits;
use App\Models\PanunoteQuizzes;
use App\Models\PanunoteSubjects;
use App\Models\PanunoteSubjectLikes;
use App\Models\PanunoteSubjectVisits;
use App\Models\PanunoteUsers;
use URL;
use Illuminate\Support\Facades\Auth;
class PanunoteSubject extends Component
{
    public $notetitle;
    public $notesharing;
    public $notetags = "";

    public $notecontent;

        
    public $note_list;
    public $sort = "";
    public $search;

    public $subjectvisits_count;
    public $subjectlikes_count;

    public $preservenote = 'option1';

    protected $listeners = [
        'set:save' => 'save',
    ];

    protected $rules = [
        'notetitle' => 'required',
    ];

    public $subject_id;
    public $subjectname;

    public $newsubject;
    public $selectsubject;

    public $allsubs;

    public $itemsCard = [];


    public $singleSelectid;



    public function move_single(){
        $note = PanunoteNotes::find($this->singleSelectid);
        $note->subject_id = $this->selectsubject;
        $note->save();
        $this->dispatchBrowserEvent('notemodifydone');
    }

    public function copy_single(){
        $note = PanunoteNotes::find($this->singleSelectid);
        $newNote = $note->replicate();
        $newNote->subject_id = $this->selectsubject;
        $newNote->save();
        $this->dispatchBrowserEvent('notemodifydone');
    }

    public function duplicate_single($noteid){
        $note = PanunoteNotes::find($noteid);
        $newNote = $note->replicate();
        $newNote->save();
        $this->dispatchBrowserEvent('notemodifydone');
    }

    
    public function delete_single($noteid){
        PanunoteNotes::find($noteid)->delete();
        $this->dispatchBrowserEvent('notemodifydone');
    }


    public function delete_selected(){
        if(empty($this->itemsCard)){
            $this->dispatchBrowserEvent('selectednotes');
        }else{

            foreach($this->itemsCard as $item){
                $note = PanunoteNotes::find(explode (",",  $item)[0])->delete();
            }

            $this->dispatchBrowserEvent('notemodifydone');
        }
    }


    public function move_selected(){
        if(empty($this->itemsCard)){
            $this->dispatchBrowserEvent('selectednotes');
        }else{
            foreach($this->itemsCard as $item){
                $note = PanunoteNotes::find(explode (",",  $item)[0]);
                $note->subject_id = $this->selectsubject;
                $note->save();
            }
            
            $this->dispatchBrowserEvent('notemodifydone');
        }
    }

    public function copy_selected(){
        if(empty($this->itemsCard)){
            $this->dispatchBrowserEvent('selectednotes');
        }else{
            foreach($this->itemsCard as $item){
                $note = PanunoteNotes::find(explode (",",  $item)[0]);
                $newNote = $note->replicate();
                $newNote->subject_id = $this->selectsubject;
                $newNote->save();
            }

            $this->dispatchBrowserEvent('notemodifydone');
        }
    }

    public function duplicate_selected(){
        if(empty($this->itemsCard)){
            $this->dispatchBrowserEvent('selectednotes');
        }else{
            foreach($this->itemsCard as $item){
                $note = PanunoteNotes::find(explode (",",  $item)[0]);
                $newNote = $note->replicate();
                $newNote->save();
            }

            $this->dispatchBrowserEvent('notemodifydone');
        }
    }

    public function delete(){

        $subject = PanunoteSubjects::where('subject_id', $this->subject_id)->first();

        if(Auth::user()->user_id == $subject->user_id){

            if($this->note_list->isEmpty()){

                PanunoteSubjectLikes::where('subject_id', $this->subject_id)->delete();
                PanunoteSubjectVisits::where('subject_id', $this->subject_id)->delete();
                PanunoteSubjects::where('subject_id', $this->subject_id)->delete();

                return redirect('subjects');

            }else{
                if($this->preservenote == "option"){
            
                        $note_delete = [];

                        foreach(PanunoteNotes::select('note_id')->where('subject_id', $this->subject_id)->get() as $note){
                            $note_delete[] = $note->note_id;
                        }

                        PanunoteQuizzes::whereIn('note_id', $note_delete)->update([
                            'note_id' => null
                        ]);

                        PanunoteNoteLikes::whereIn('note_id', $note_delete)->delete();
                        PanunoteNoteVisits::whereIn('note_id', $note_delete)->delete();
                        PanunoteNotes::where('subject_id', $this->subject_id)->delete();

                        PanunoteSubjectLikes::where('subject_id', $this->subject_id)->delete();
                        PanunoteSubjectVisits::where('subject_id', $this->subject_id)->delete();
                        PanunoteSubjects::where('subject_id', $this->subject_id)->delete();

                }elseif($this->preservenote == "option1"){

                    if(!empty($this->newsubject) || !is_null($this->newsubject) || !$this->newsubject == ""){

                        $new = PanunoteSubjects::create([
                            'subject_name' => $this->newsubject,
                            'user_id' => $subject->user_id,
                            'subject_sharing' => 0
                        ])->subject_id;

                        PanunoteNotes::where('subject_id', $this->subject_id)->update([
                            'subject_id' => $new
                        ]);

                        PanunoteSubjectLikes::where('subject_id', $this->subject_id)->delete();
                        PanunoteSubjectVisits::where('subject_id', $this->subject_id)->delete();
                        PanunoteSubjects::where('subject_id', $this->subject_id)->delete();
                        
                        
                        return redirect('subjects');
             
                        
                    }else{
                        $this->dispatchBrowserEvent('SubjectRequired');
                    }

                }elseif($this->preservenote == "option2"){
        
                    if(!empty($this->selectsubject) || !is_null($this->selectsubject)){

                        if(PanunoteSubjects::where('subject_id', $this->selectsubject)->exists()){
                            PanunoteNotes::where('subject_id', $this->subject_id)->update([
                                'subject_id' => $this->selectsubject
                            ]);

                            PanunoteSubjectLikes::where('subject_id', $this->subject_id)->delete();
                            PanunoteSubjectVisits::where('subject_id', $this->subject_id)->delete();
                            PanunoteSubjects::where('subject_id', $this->subject_id)->delete();
        
                        }else{
                            $this->dispatchBrowserEvent('error');
                        }

                        return redirect('subjects');

                    }else{
                        $this->dispatchBrowserEvent('SelectRequired');
                    }
                }else{
                    $this->dispatchBrowserEvent('error');
                }  

            }
 
        }else{
            $this->dispatchBrowserEvent('error');
        }

        return redirect('/subjects');

    }

	public function mount($subject_id=null)
	{
        $subject = PanunoteSubjects::where('subject_id', $this->subject_id)->first();

        if(!is_null($subject)){
            if(Auth::user()->user_id != $subject->user_id){
                if($subject->subject_sharing == 1 && !empty(Auth::user()->user_id)){
    
                    $a = PanunoteUsers::where('user_id', $subject->user_id)->first('username');
                    return redirect()->to('/'.$a->username.'/subjects/'.$this->subject_id);
                    
    
                }elseif($subject->subject_sharing == 0 && !empty(Auth::user()->user_id)){
                    return dd('Private');
                }else{
                    abort(404);
                }
            }
        }else{
            abort(404);
        }

		$this->subject_id = $subject_id;
        $subject = PanunoteSubjects::where('subject_id', $this->subject_id)->first();
        $this->subjectname = $subject->subject_name;

        //sharing
        $this->sharing = ($subject->subject_sharing == 0) ? false : true;

        $this->urlsharing = URL::current();

        if($this->sharing == "true"){
          $this->urlsharing = $this->urlsharing;
        }else{
          $this->urlsharing = "";
        }

        //favorite
        $like = PanunoteSubjectLikes::where([
            ['subject_id', $this->subject_id],
            ['user_id', Auth::user()->user_id]
        ])->first();

        $this->isfavorite = (!is_null($like) && $like->subject_like == 1) ? true : false;


        //analytics
        $this->subjectlikes_count = PanunoteSubjectLikes::where('subject_id', $this->subject_id)->where('subject_like', 1)->count();
        $this->subjectvisits_count = PanunoteSubjectVisits::where('subject_id', $this->subject_id)->count();


        //get all subjects
        $this->allsubs = PanunoteSubjects::where('user_id', Auth::user()->user_id)->where('subject_id', '!=', $this->subject_id)->get();
    
        
        if(!$this->allsubs->isEmpty()){
            $this->selectsubject = $this->allsubs[0]['subject_id'];
        }
	}

    public function save(){
        PanunoteSubjects::where('subject_id', $this->subject_id)
        ->update(['subject_name' => $this->subjectname]);
    }

    public function sharingsetting(){
        $this->sharing = $this->sharing;

        PanunoteSubjects::where('subject_id', $this->subject_id)
        ->update(['subject_sharing' => ($this->sharing == "true") ? 1 : 0]);

        if($this->sharing == "true"){
            $this->urlsharing = URL::previous();
        }else{
            $this->urlsharing = "";
        }
    }

    public function like(){
        $this->isfavorite = !$this->isfavorite;

        $isexist = PanunoteSubjectLikes::where([
            ['subject_id', $this->subject_id],
            ['user_id', Auth::user()->user_id]
        ])->exists();

        if($isexist){
            //update
            PanunoteSubjectLikes::where('subject_id', $this->subject_id)
            ->where('user_id', Auth::user()->user_id)
            ->update(['subject_like' => ($this->isfavorite) ? 1 : 0]);

        }else{
            //create
            PanunoteSubjectLikes::create([
                'subject_id' => $this->subject_id,
                'user_id' => Auth::user()->user_id,
                'subject_like' => ($this->isfavorite) ? 1 : 0
            ]);
        }

    }

    public function submit(){

        $this->validate();

        $sharing = 0;

        if($this->notesharing){
            $sharing = 1;
        }

        if(is_null($this->notecontent) || empty($this->notecontent)){
            $this->notecontent = "";
        }

        $addsubject = PanunoteNotes::create([
            'note_content' => $this->notecontent,
            'note_tags' => $this->notetags,
            'note_sharing' => $sharing,
            'note_title' => $this->notetitle,
            'subject_id' => $this->subject_id,
            'user_id' => Auth::user()->user_id
        ]);

        $this->dispatchBrowserEvent('creatednote');

    }


    public function render()
    {
        $subject = PanunoteSubjects::where('subject_id', $this->subject_id)->first();

        //$this->note_list = PanunoteNotes::where('subject_id', $this->subject_id)->get();
        
        $this->note_list = PanunoteNotes::searchall($this->search)
        ->where('subject_id', $this->subject_id)
        ->when(empty($this->search), function ($query) {
            $query->where('note_id', '>', 0);
        })
        ->when(!empty($this->sort), function ($query) {
            if($this->sort == 'lto'){
                $query->orderBy('updated_at', 'DESC');
            }elseif($this->sort == 'otl'){
                $query->orderBy('updated_at', 'ASC');
            }elseif($this->sort == 'atz'){
                $query->orderBy('note_title', 'ASC');
            }elseif($this->sort == 'zta'){
                $query->orderBy('note_title', 'DESC');
            }
        })
        ->get();

  


        return view('livewire.panunote-subject', ['notes' => $this->note_list, 'subject_details' => $subject]);
    }
}

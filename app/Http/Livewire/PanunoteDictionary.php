<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
class PanunoteDictionary extends Component
{
    protected $listeners = [
        'search' => 'search',
    ];
    
    public $searchinput;
    public $res = [];
    public $audio;
    public $word;

    public $definition = [];
    public $selectedword;

    public $hasphonetic = true;

    public $synonyms;
    public $antonyms;

    public $soundlike;

    public $notfound = false;


    public function findword($word){
        
        $this->hasphonetic = true;
        $this->audio = null;
  
        $this->selectedword = $word;
        $this->word = $word;

        $client = new \GuzzleHttp\Client((['http_errors' => false]));
        $response = $client->get('https://api.dictionaryapi.dev/api/v2/entries/en/'. $this->word);
        $response_body = (string)$response->getBody();
        $res = json_decode($response_body, true);

        $statuscode = $response->getStatusCode();

        if($statuscode == 404){
                $this->notfound = true;
                $this->res = [];
        }else{
                $this->notfound = false;
                //syn
                $responsesyn = $client->get('https://api.datamuse.com/words?rel_syn='.$this->word.'&md=p');
                $responsesyn_body = (string)$responsesyn->getBody();
                $ressyn = json_decode($responsesyn_body, true);
        
                $this->synonyms = [
                    "synonyms_count" => 0,
                    ["pof" => 'noun', 'word' => []], 
                    ["pof" => 'verb', 'word' => []], 
                    ["pof" => 'adverb', 'word' => []], 
                    ["pof" => 'adjective', 'word' => []], 
                ];
        
                foreach($ressyn as $syn){
                    if(isset($syn['tags'])){
                        foreach($syn['tags'] as $pof){
                            if($pof == 'n'){
                                $this->synonyms['synonyms_count']++;
                                $this->synonyms[0]['word'][] = $syn['word'];
                            }elseif($pof == 'v'){
                                $this->synonyms['synonyms_count']++;
                                $this->synonyms[1]['word'][] = $syn['word'];
                            }elseif($pof == 'adv'){
                                $this->synonyms['synonyms_count']++;
                                $this->synonyms[2]['word'][] = $syn['word'];
                            }elseif($pof == 'adj'){
                                $this->synonyms['synonyms_count']++;
                                $this->synonyms[3]['word'][] = $syn['word'];
                            }
                        }
                    }
        
                }
        
        
                //ant
                $responseant = $client->get('https://api.datamuse.com/words?rel_ant='.$this->word.'&md=p');
                $responseant_body = (string)$responseant->getBody();
                $resant = json_decode($responseant_body, true);
        
                $this->antonyms = [
                    "antonyms_count" => 0,
                    ["pof" => 'noun', 'word' => []], 
                    ["pof" => 'verb', 'word' => []], 
                    ["pof" => 'adverb', 'word' => []], 
                    ["pof" => 'adjective', 'word' => []], 
                ];
        
                foreach($resant as $ant){
                    if(isset($ant['tags'])){
                        foreach($ant['tags'] as $pof){
                            if($pof == 'n'){
                                $this->antonyms['antonyms_count']++;
                                $this->antonyms[0]['word'][] = $ant['word'];
                            }elseif($pof == 'v'){
                                $this->antonyms['antonyms_count']++;
                                $this->antonyms[1]['word'][] = $ant['word'];
                            }elseif($pof == 'adv'){
                                $this->antonyms['antonyms_count']++;
                                $this->antonyms[2]['word'][] = $ant['word'];
                            }elseif($pof == 'adj'){
                                $this->antonyms['antonyms_count']++;
                                $this->antonyms[3]['word'][] = $ant['word'];
                            }
                        }
                    }
        
                }

                //sl
                $responsesl = $client->get('https://api.datamuse.com/words?sl='.$this->word);
                $responsesl_body = (string)$responsesl->getBody();
                $this->soundlike = json_decode($responsesl_body, true);

                //dd($this->antonyms);
                

                // foreach($res as $this->definition){

                //     $phoneticcount = 0;
                //     foreach($this->definition['phonetics'] as $phonetic){
                //         if(empty($phonetic['audio']) || empty($phonetic['text'])){
                //             unset($this->definition['phonetics'][$phoneticcount]);
                //         }
                //         $phoneticcount++;
                //     }

                //     $meaningcount = 0;
                //     $duplicates = [];
                //     foreach($this->definition['meanings'] as $mean){

                //         if(in_array($mean['partOfSpeech'], $duplicates)){
                //             foreach($mean['definitions'] as $define){
                //                 $this->definition['meanings'][array_keys($duplicates, $mean['partOfSpeech'])[0]]['definitions'][] = $define;
                //             }
                //             unset($this->definition['meanings'][$meaningcount]);
                //         }else{
                //             $duplicates[$meaningcount] = $mean['partOfSpeech'];
                //         }

                //         $meaningcount++;
                //     }

                // }

                foreach($res as $this->definition){

                    $meaningcount1 = 0;
                    foreach($this->definition['meanings'] as $meaning){
                        $test[] = $meaning;
                        unset($this->definition['meanings'][$meaningcount1]);
        
                        $meaningcount1++;
                    }
        
                    $this->definition['meanings'] = $test;
        
                    $phoneticcount = 0;
                    foreach($this->definition['phonetics'] as $phonetic){
                        if(empty($phonetic['audio']) || empty($phonetic['text'])){
                            unset($this->definition['phonetics'][$phoneticcount]);
                        }
                        $phoneticcount++;
                    }
        
                    $meaningcount = 0;
                    $duplicates = [];
                    foreach($this->definition['meanings'] as $mean){
        
                        if(in_array($mean['partOfSpeech'], $duplicates)){
                            foreach($mean['definitions'] as $define){
                                $this->definition['meanings'][array_keys($duplicates, $mean['partOfSpeech'])[0]]['definitions'][] = $define;
                            }
                            unset($this->definition['meanings'][$meaningcount]);
                        }else{
                            $duplicates[$meaningcount] = $mean['partOfSpeech'];
                        }
        
                        $meaningcount++;
                    }
        
                }

                if(!empty($this->definition['phonetics'])){
                    foreach($this->definition['phonetics'] as $sound){
                        $this->audio = $sound['audio'];
                        $this->definition['phonetics'] = $sound['text'];
                    }
                    $this->hasphonetic = true;
                }else{
                    $this->hasphonetic = false;
                }


        }

        $this->dispatchBrowserEvent('contentChanged');

        //dd($this->definition['phonetics'], $this->audio, $this->hasphonetic);

    }

    public function search(){
        $this->notfound = false;

        if(!$this->searchinput == ""){
            $client = new \GuzzleHttp\Client();
            $response = $client->get('https://api.datamuse.com/sug?v=rz_full&k=rz_sugj&s='. $this->searchinput);
            $response_body = (string)$response->getBody();
            $a = json_decode($response_body, true);

            $this->res = $a;
        }
        //$matches  = preg_grep ('/^hello (\w+)/i', json_decode($a, true));
    }

    public function mount(){
        $test = [];
        $this->word = "Placeholder";
        $this->res = [];

        $client = new \GuzzleHttp\Client();
        $response = $client->get('https://api.dictionaryapi.dev/api/v2/entries/en/note');
        $response_body = (string)$response->getBody();
        $res = json_decode($response_body, true);

        //syn
        $responsesyn = $client->get('https://api.datamuse.com/words?rel_syn=note&md=p');
        $responsesyn_body = (string)$responsesyn->getBody();
        $ressyn = json_decode($responsesyn_body, true);

        $this->synonyms = [
            "synonyms_count" => 0,
             ["pof" => 'noun', 'word' => []], 
             ["pof" => 'verb', 'word' => []], 
             ["pof" => 'adverb', 'word' => []], 
             ["pof" => 'adjective', 'word' => []], 
         ];
 
         foreach($ressyn as $syn){
             if(isset($syn['tags'])){
                 foreach($syn['tags'] as $pof){
                     if($pof == 'n'){
                        $this->synonyms['synonyms_count']++;
                         $this->synonyms[0]['word'][] = $syn['word'];
                     }elseif($pof == 'v'){
                        $this->synonyms['synonyms_count']++;
                         $this->synonyms[1]['word'][] = $syn['word'];
                     }elseif($pof == 'adv'){
                        $this->synonyms['synonyms_count']++;
                         $this->synonyms[2]['word'][] = $syn['word'];
                     }elseif($pof == 'adj'){
                        $this->synonyms['synonyms_count']++;
                         $this->synonyms[3]['word'][] = $syn['word'];
                     }
                 }
             }
 
         }


        //ant
        $responseant = $client->get('https://api.datamuse.com/words?rel_ant=note&md=p');
        $responseant_body = (string)$responseant->getBody();
        $resant = json_decode($responseant_body, true);

        $this->antonyms = [
            "antonyms_count" => 0,
             ["pof" => 'noun', 'word' => []], 
             ["pof" => 'verb', 'word' => []], 
             ["pof" => 'adverb', 'word' => []], 
             ["pof" => 'adjective', 'word' => []], 
         ];
 
         foreach($resant as $ant){
             if(isset($ant['tags'])){
                 foreach($ant['tags'] as $pof){
                     if($pof == 'n'){
                         $this->antonyms['antonyms_count']++;
                         $this->antonyms[0]['word'][] = $ant['word'];
                     }elseif($pof == 'v'){
                         $this->antonyms['antonyms_count']++;
                         $this->antonyms[1]['word'][] = $ant['word'];
                     }elseif($pof == 'adv'){
                         $this->antonyms['antonyms_count']++;
                         $this->antonyms[2]['word'][] = $ant['word'];
                     }elseif($pof == 'adj'){
                         $this->antonyms['antonyms_count']++;
                         $this->antonyms[3]['word'][] = $ant['word'];
                     }
                 }
             }
 
         }


        //sl
        $responsesl = $client->get('https://api.datamuse.com/words?sl=note');
        $responsesl_body = (string)$responsesl->getBody();
        $this->soundlike = json_decode($responsesl_body, true);

        
        
        foreach($res as $this->definition){

            $meaningcount1 = 0;
            foreach($this->definition['meanings'] as $meaning){
                $test[] = $meaning;
                unset($this->definition['meanings'][$meaningcount1]);

                $meaningcount1++;
            }

            $this->definition['meanings'] = $test;

            $phoneticcount = 0;
            foreach($this->definition['phonetics'] as $phonetic){
                if(empty($phonetic['audio']) || empty($phonetic['text'])){
                    unset($this->definition['phonetics'][$phoneticcount]);
                }
                $phoneticcount++;
            }

            $meaningcount = 0;
            $duplicates = [];
            foreach($this->definition['meanings'] as $mean){

                if(in_array($mean['partOfSpeech'], $duplicates)){
                    foreach($mean['definitions'] as $define){
                        $this->definition['meanings'][array_keys($duplicates, $mean['partOfSpeech'])[0]]['definitions'][] = $define;
                    }
                    unset($this->definition['meanings'][$meaningcount]);
                }else{
                    $duplicates[$meaningcount] = $mean['partOfSpeech'];
                }

                $meaningcount++;
            }

        }


        foreach($this->definition['phonetics'] as $sound){
            $this->audio = $sound['audio'];
            $this->definition['phonetic'] = $sound['text'];
        }




        //dd($this->audio);



    }

    public function render()
    {
        return view('livewire.panunote-dictionary');
    }
}

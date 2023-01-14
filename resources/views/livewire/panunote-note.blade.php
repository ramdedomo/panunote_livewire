<div>
    <div wire:ignore.self class="modal fade" id="deleteNote" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Are you sure to Delete <strong>{{ $note_details->note_title }} (Note) </strong>?</h5>
              <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>
            <div class="modal-body">

            <div class="row gy-2 gx-2">

                <div class="col-6">
                    <div class="bg-semi-dark rounded-3 p-2 align-items-center">
                        <i class="bi bi-heart-fill text-primary"></i> <strong>{{$notelikes_count}}</strong> Public Likes 
                    </div>
                </div>

                <div class="col-6">
                    <div class="bg-semi-dark rounded-3 p-2">
                        <i class="bi bi-door-open-fill text-primary"></i> <strong>{{$notevisits_count}}</strong> Public Visits
                    </div>
                </div>

            </div>
    
            </div>

            <div class="modal-footer">
                <button data-bs-dismiss="modal" aria-label="Close" type="button" class="btn bg-secondary text-light">Cancel</button>
                <button wire:click="delete" type="button" class="btn bg-warning text-light">Delete</button>
            </div>
          </div>
        </div>
      </div>

    <div wire:ignore.self class="modal fade" id="editTag" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel"><strong>{{ $note_details->note_title }}</strong> Tags</h5>
              <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>
            <div class="modal-body">

              <div class="">
                    <div class="bg-semi-dark p-2 rounded text-secondary text-center mb-2">
                        <i class="bi bi-info-circle"></i> Seperate Tags using <strong>","</strong> &nbsp;&nbsp; / &nbsp;&nbsp;  <strong>Example: Panunote,Panugame</strong> 
                    </div>
                    <div class="form-floating">
                        <textarea wire:model.defer="notetags" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Tags</label>
                    </div>
            </div>
            
        
            </div>

            <div class="modal-footer">
                <button wire:click="updateTag" data-bs-dismiss="modal" aria-label="Close" type="button" class="btn btn-primary">Update</button>
            </div>
          </div>
        </div>
      </div>

    <div wire:ignore.self class="modal fade" id="takequiz" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel"><strong>{{ $note_details->note_title }}</strong> Quizzes</h5>
              <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>
            <div class="modal-body">

             
                @if($generated_quizzes->isEmpty())

                <div class="card p-2 bg-semi-dark rounded mb-2">
                    <div class="d-flex justify-content-center align-items-center">
                        No Available Quizzes
                    </div>
                </div>
                @else
                @foreach ($generated_quizzes as $quiz)
                <div class="card quiz-picker p-2 rounded mb-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                             <strong>Take -</strong> {{$quiz->quiz_title}}
                        </div>


                        <div>
                            <strong>{{$quiz->items}}</strong> items
                            <a target="_blank" href="{{route('takequiz', ['quiz_id'=>$quiz->quiz_id])}}" class="stretched-link"></a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
     
       

                
            </div>
            <div class="modal-footer">
                {{-- <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button> --}}
            </div>
          </div>
        </div>
      </div>

    <div wire:ignore.self class="modal fade" id="sharingsettings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel"><strong>Sharing</strong> Settings</h5>
              <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-6">
                        Sharing:
                    </div>

                    <div class="col-6">
                        URL:
                    </div>
                </div>
              
                <div class="row">
                    <div class="col-6">
                        <select wire:change="sharingsetting" wire:model="sharing" class="form-select">
                            <option value="true">On</option>
                            <option value="false">Off</option>
                          </select>
                    </div>

                    <div class="col-6">
                        <input wire:model.defer="urlsharing" class="form-control" type="text" disabled>
                    </div>
                </div>
        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Done</button>
            </div>
          </div>
        </div>
      </div>

    <div wire:model="modal" wire:ignore.self class="modal fade" id="staticBackdrop_generated" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Generated Questions</h5>
                <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>

         
                <div class="modal-body">
                    <div>

                        <div class="mb-2">
                            Quizz Title:
                            <input @error('quiztitle') placeholder="{{$message}}"  @enderror type="text" wire:model="quiztitle" class="form-control">
                        </div>

                        <div class="row gx-2 my-2">
                            <div class="col-3">
                                Answers:
                            </div>
                            <div class="col-7">
                                Questions:
                            </div>
                            <div class="col-2">
                                Difficulty:
                            </div>
                        </div>

                        @php
                            $count = 0;
                        @endphp
                        @foreach (array_combine($finalanswers, $finalquestions) as $answer => $question) 
                        <div class="row gx-2 mb-2">
                            <div class="col-3">
                                <textarea cols="1" rows="1" value="{{$answer}}" type="text" disabled class="form-control">{{$answer}}</textarea>
                            </div>
                            <div class="col-7">
                                <textarea disabled class="form-control" name="" id="" cols="1" rows="1">{{$question[0]}}</textarea>
                            </div>

                            <div class="col-2">
                                <select wire:model="finaldifficulty.{{$count}}" class="form-select" aria-label="Default select example">
                                    <option value="1">Easy</option>
                                    <option value="2">Intermediate</option>
                                    <option value="3">Hard</option>
                                </select>

                                {{-- <textarea disabled class="form-control" name="" id="" cols="1" rows="1">{{$finaldifficulty[$count]}}</textarea> --}}
                            </div>
                        </div>
                        
                        @php
                            $count++;
                        @endphp

                        @endforeach

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button wire:click="savegenerated" id="submit" class="btn btn-primary">Save</button>
                </div>
        
        </div>
    </div>
    </div>

    <div wire:model="modal" wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Paraphrase</h5>
                <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>

         
                <div class="modal-body">
                    <div class="row gy-3">
                        <div>
                            Text:
                            <textarea wire:model="defaulttext" disabled class="form-control" name="" id="defaulttext" cols="30" rows="2"></textarea>
                        </div>

                        <div>
                            Paraphrased Text:
                            <textarea wire:model="paraphrasedtext" disabled class="form-control" name="" id="paraphrasedtext" cols="30" rows="2"></textarea>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="replace" class="btn btn-primary">Replace</button>
                    <button onclick="copytoclipboard()" id="submit" class="btn btn-primary">Copy</button>
                </div>
        
            
        </div>
    </div>
    </div>


    <main class="">
        <div class="">
            {{-- <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1> --}}
            <div class="sticky-top bg-white p-0 m-0 border-bottom border-2 border-primary">
                <div class="sizebox"></div>

                <div style="margin-top: 60px;" class="pt-1 offcanvas offcanvas-end" tabindex="-2" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                <div class="offcanvas-header bg-primary d-flex align-items-center">

                    <div id="offcanvasRightLabel">
                        <span class="fw-bold fs-3 text-light">Dictionary</span></div>
                    <button type="button" class="btn-close  btn-close-white text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>

                <div class="offcanvas-body" id="dictionary_body">

                    @if(!$notfound)
                    <div>
                        <div>
                            <div disabled type="text" class="form-control fs-1 mb-2 p-0 px-2">
                                @if (isset($definition['word'])) {{ucfirst($definition['word'])}} @endif
                            </div>
                        </div>

                        <div class="">
                            <p class="fs-4">
                                @if (isset($definition['phonetic']))
                                {{$definition['phonetic']}}
                                    @if($hasphonetic) 
                                        <button type="button" class="phonetics btn btn-outline-primary rounded-5 px-1 py-0"><i class="fs-4 bi bi-volume-up"></i></button> 
                                    @else 
                                        <button type="button" class="disabled btn btn-outline-secondary rounded-5 px-1 py-0"><i class="fs-4 bi bi-volume-up"></i></button> 
                                    @endif
                                @else
                                    <button type="button" class="disabled btn btn-outline-secondary rounded-5 px-1 py-0"><i class="fs-4 bi bi-volume-up"></i></button> 
                                @endif </p>
                        </div>

                    </div>

                    <div class="mt-4">

                        <div class="d-flex">
                            <span class="border-start border-5 border-info fw-bold bg-semi-dark w-100 py-1 px-2 rounded">Meanings</span>
                        </div>


                        <div class="accordion mt-3" id="accordionPanelsStayOpenExample">

                            @php
                                $count = 0;
                                $headerid = "panelsStayOpen-heading";
                                $contentid = "panelsStayOpen-collapse";
                            @endphp

                       
                            @foreach ($definition['meanings'] as $define)

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{$headerid.$count}}">
                                  <button class="accordion-button p-3" type="button" data-bs-toggle="collapse" data-bs-target="#{{$contentid.$count}}" aria-expanded="true" aria-controls="{{$contentid.$count}}">
                                    {{ucfirst($define['partOfSpeech'])}}
                                  </button>
                                </h2>
                                <div id="{{$contentid.$count}}" class="accordion-collapse collapse show" aria-labelledby="{{$headerid.$count}}">
                                  <div class="accordion-body p-3">
                                    <strong>Definitions:</strong> 
                                    <ul>

                                        @foreach ($define['definitions'] as $definition)
                                            <li>{{$definition['definition']}}</li>

                                            @if(isset($definition['example']))
                                                <ul>
                                                    <li>{{$definition['example']}}</li>
                                                </ul>
                                            @endif

                                        @endforeach
                                        
                                    </ul>
                                  </div>
                                </div>
                            </div>

                              @php
                                  $count++;
                              @endphp

                            @endforeach

                          </div>

                          
                        <div class="d-flex mt-3">
                            <span class="border-start border-5 border-info fw-bold bg-semi-dark w-100 py-1 px-2 rounded">Antonyms</span>
                        </div>


                        <div class="accordion mt-3" id="accordionPanelsStayOpenExample">

                            @php
                                $count = 0;
                                $headerid = "ant_panelsStayOpen-heading";
                                $contentid = "ant_panelsStayOpen-collapse";
                            @endphp

                            @if($antonyms['antonyms_count'] == 0)
                            <div class="d-flex mt-3">
                                <span class="text-center w-100 p-3 bg-semi-dark fw-bold"> NO ANTONYMS FOUND</span>
                            </div>
                              
                            @endif
                       
                            @foreach ($antonyms as $words)

                            @if(!empty($words['word']))

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{$headerid.$count}}">
                                  <button class="accordion-button p-3" type="button" data-bs-toggle="collapse" data-bs-target="#{{$contentid.$count}}" aria-expanded="true" aria-controls="{{$contentid.$count}}">
                                    {{ucfirst($words['pof'])}}
                                  </button>
                                </h2>
                                <div id="{{$contentid.$count}}" class="accordion-collapse collapse show" aria-labelledby="{{$headerid.$count}}">
                                  <div class="accordion-body p-3">
                                    @foreach ($words['word'] as $word)
                                    <span wire:click="findword('{{$word}}')" class="btn badge text-bg-info">{{$word}}</span>
                                    @endforeach
                                  </div>
                                </div>
                            </div>

                            @endif

                              @php
                                  $count++;
                              @endphp

                            @endforeach

                        </div>





                        <div class="d-flex mt-3">
                            <span class="border-start border-5 border-info fw-bold bg-semi-dark w-100 py-1 px-2 rounded">Synonyms</span>
                        </div>

                        <div class="accordion mt-3" id="accordionPanelsStayOpenExample">

                            @php
                                $count = 0;
                                $headerid = "syn_panelsStayOpen-heading";
                                $contentid = "syn_panelsStayOpen-collapse";
                            @endphp

                            @if($synonyms['synonyms_count'] == 0)
                            <div class="d-flex mt-3">
                                <span class="text-center w-100 p-3 bg-semi-dark fw-bold"> NO SYNONYMS FOUND</span>
                            </div> 
                            @endif

                            @foreach ($synonyms as $words)

                            @if(!empty($words['word']))

                            <div class="accordion-item">
                                <h2 class="accordion-header" id="{{$headerid.$count}}">
                                  <button class="accordion-button p-3" type="button" data-bs-toggle="collapse" data-bs-target="#{{$contentid.$count}}" aria-expanded="true" aria-controls="{{$contentid.$count}}">
                                    {{ucfirst($words['pof'])}}
                                  </button>
                                </h2>
                                <div id="{{$contentid.$count}}" class="accordion-collapse collapse show" aria-labelledby="{{$headerid.$count}}">
                                  <div class="accordion-body p-3">
                                    @foreach ($words['word'] as $word)
                                        <span wire:click="findword('{{$word}}')" class="btn badge text-bg-info">{{$word}}</span>
                                    @endforeach
                                  </div>
                                </div>
                            </div>

                            @endif

                              @php
                                  $count++;
                              @endphp

                            @endforeach

                        </div>


                        <div class="d-flex mt-3">
                            <span class="border-start border-5 border-info fw-bold bg-semi-dark w-100 py-1 px-2 rounded">Soundlike</span>
                        </div>

                        <div class="p-3 bg-semi-dark rounded mt-3">
                        @foreach ($soundlike as $sl)
                        <span wire:click="findword('{{$sl['word']}}')" class="btn badge text-bg-info"> {{$sl['word']}}</span>
                           
                        @endforeach
                        </div>


                    </div>
                    @else
                    <div class="bg-semi-dark d-flex justify-content-center align-items-center p-2 mt-3">
                        No Definition Available - Find on &nbsp; <a target="_blank" class="fw-bold" href="https://www.google.com/search?q={{$word}}+definition">Google</a> 
                    </div>

                    @endif

                </div>
                </div>



                <div class="p-3 m-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ url('subjects/') }}" class="btn py-1 text-light bg-primary"><i class="bi bi-journals"></i> Subjects</a>

                            <span class="">|</span>
                            <a href="{{ url('subjects/'.$subject_details->subject_id) }}" class="btn py-1 px-2 text-light bg-primary">
                                <span class="d-none d-md-block">{{ $subject_details->subject_name }}</span>
                                <span class="d-block d-md-none"><i class="bi bi-journals"></i></span>
                            </a>
                            
                            <button disabled class="btn py-1 px-2 text-light bg-primary">
                                <span class="d-none d-md-block">{{ $note_details->note_title }}</span>
                                <span class="d-block d-md-none"><i class="bi bi-journal"></i></span>
                            </button>
                            {{-- <span class="mx-2">|</span> --}}
                        </div>

                        <div>
                            <span wire:loading>
                                <div class="bg-semi-dark rounded-3 py-1 px-2">
                                    <div id="spinner" class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0" role="status" aria-hidden="true"></div>
                                     &nbsp; Please Wait ...
                                </div>
                            </span>


                            @if(!empty($word))
                            <button class="btn btn-primary py-1 px-2 mx-1" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><i class="bi bi-book"></i></button>
                            @endif

                            @if($isgenerated)
                            <button data-bs-toggle="modal" data-bs-target="#staticBackdrop_generated" class="btn py-1 px-2 mx-1 bg-primary"><i class="text-light bi bi-card-checklist"></i></button>
                            @endif
                            
                            <button wire:click="generate" class="btn py-1 bg-primary text-light tooltip-container">
                                <span class="d-none d-md-block"><i class="bi bi-gear-fill"></i> Generate Questions</span><span class="d-block d-md-none">
                                    <i class="bi bi-lightbulb"></i>
                                </span>
                                <span style="right: -10px" class="tooltip">To Generate Question highlight possible answer in the note below. <br><br>Follow this Steps: <br> <strong>Mark</strong>  -> <strong>Save</strong> -> <strong>Generate</strong></span>
                            </button>
                            
                            <span class="">|</span>

                            <button data-bs-toggle="modal" data-bs-target="#takequiz" class="btn py-1 px-2 bg-primary text-light tooltip-container">
                                Take Quiz
                                <span class="tooltip">Take a quiz from this note's generated quizzes.</span>
                            </button>
                           
                            <button data-bs-toggle="modal" data-bs-target="#sharingsettings" class="btn py-1 px-2 bg-primary"><i class="text-light bi bi-share"></i>&nbsp;<span class="text-light">Share</span></button>
                            <button wire:click="like" class="btn py-1 px-2 bg-primary"> @if($isfavorite) <i class="text-light bi bi-heart-fill"></i> @else <i class="text-light bi bi-heart"></i> @endif</button>
                            <span >|</span>
                            <button data-bs-toggle="modal" data-bs-target="#deleteNote" class="btn py-1 px-2 bg-warning"><i class="text-light bi bi-journal-x"></i></button>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div>
                            <input type="text" wire:model="notetitle" class="border-3 border-bottom border-primary notecontroller form-control fs-1 mb-2 p-0 px-2 border-1">
                        </div>

                        <div class="d-flex justify-content-between mt-3">

                            <div>
                                <span class="badge bg-info"><i class="bi bi-tag-fill"></i></span>
                                @foreach (explode (",", $note_details->note_tags ) as $tag)
                                    <a href="#" class="btn text-light badge bg-info">{{$tag}}</a>
                                @endforeach
                                <span  data-bs-toggle="modal" data-bs-target="#editTag" class="btn text-info badge border-1 border-info"><i class="bi bi-pencil-fill"></i> Edit</span>
                            </div>

                            {{-- <div wire:poll.60s="draft"> --}}
                            <div>
                                @if($saved == 1)
                                    <span class="saved badge bg-primary">
                                    Saved 
                                    @php
                                        echo Carbon\Carbon::now('Asia/Manila')->format('h:i:s');
                                    @endphp
                                    </span>
                                @endif
                            </div>
    
                            
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- <button id="getvalue" class="m-3">get value</button> --}}
            {{-- <button id="getautosave">get saved</button> --}}

    

            <div class="p-3" wire:ignore>
                
                <div class="alert alert-secondary alert-dismissible fade show m-0 mb-2" role="alert">
                    <div class="alert-message">
                        <i class="bi bi-info-circle-fill"></i> <strong>To Paraphrase</strong> highlight the sentence and right click, choose  <strong>Paraphrase</strong> 
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>

                <textarea wire:model.defer="notecontent" id="noteareaID"></textarea>
            </div>

            <audio id="audio" src="{{$audio}}"></audio>

            <script>

                window.addEventListener('wordresult', event => {
                    $('#dictionary_body').animate({ //animate element that has scroll
                scrollTop: 0  //for scrolling
            }, 500);

                    $('.phonetics').click(function(){
                        var audio = document.getElementById("audio");
                        audio.play();
                    });
                })

                document.addEventListener('livewire:load', function () {
                    $( "#replace" ).click(function() {
                        tinymce.activeEditor.execCommand('mceReplaceContent', false, @this.paraphrasedtext.toString());

                        $(".content-toast").text('Paraphrased Text Replaced!');
                        const toast = new bootstrap.Toast($('#liveToast'));
                        toast.show();
                    });
                });


                document.addEventListener('keydown', (e) => {
                    if (e.ctrlKey && String.fromCharCode(e.keyCode).toLowerCase() === 's') {
                        e.preventDefault();
                        e.stopPropagation();
                        window.livewire.emit('set:submit');

                    }
                }, false);


                

            </script>
    
            <script src="{{ asset('js/tinymce.js') }}"></script>

            

                
        </div>
    </main>
</div>
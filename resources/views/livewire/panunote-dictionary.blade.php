<div>
    <main class="">
        <div class="">
            <div class="p-0 m-0">
                <div class="vh-100 d-flex" style="padding-top: 65px;">
                    <div class="w-25 bg-semi-dark border-bottom border-5 border-primary" style="overflow-y: auto">

                        <div class="d-flex p-3">
                            <input wire:model="searchinput" class="search form-control" type="text" placeholder="Search Word"
                            aria-label="default input example">
                            <span class="mx-1"></span>

                            <button id="searchword" class="py-1 px-2 btn btn-primary">
                                <span wire:loading>
                                    <div id="spinner" class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                                        role="status" aria-hidden="true"></div>
                                </span>
                                <i wire:loading.remove class="bi bi-search"></i>
                            </button>
                            
                        </div>

          

                        @if(!isset($searchinput))

                            @for ($i = 0; $i < 12; $i++)
                            <hr style="border: none;
                            height: 2px;
                            background-color: #dce0e4;" class="fw-bold p-0 m-0 mx-3 mb-4 pb-1 rounded-5">
                            @endfor

                        @endif
                 
                  


                        <ul class="sidebar-nav-right">

                                @foreach ($res as $word)
                                <li class="sidebar-item-right  @if($word['word'] == $selectedword) active @endif">
                                    <a class="sidebar-link-right" wire:click="findword('{{$word['word']}}')">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <span style="word-break: break-all;" class="align-middle">{{ucfirst($word['word'])}}</span>
                                            </div>
                                            <div class="mx-3"></div>
                                            <i class="bi bi-arrow-right-short m-0"></i>
                                        </div>
                                    </a>
                                </li>

                                <hr style="border: none;
                                height: 2px;
                                background-color: #ced4da;" class="fw-bold p-0 m-0 mx-3 mb-2">

                                

                                @endforeach
                     
                        </ul>




                    </div>

                    <div id="main_content" class="w-100 p-3 border-bottom border-5 border-primary" style="overflow-y: auto">

                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="{{ url('dictionary/') }}" class="btn py-1 text-light bg-primary"><i class="bi bi-book"></i></a>
                                <span class="mx-1">|</span>
                                {{-- <span class="mx-2">|</span> --}}
                                <a href="" class="btn py-1 px-2 text-light bg-primary">
                                    <span class="d-none d-md-block">@if(!$notfound) @if (isset($definition['word'])) {{ucfirst($definition['word'])}} @endif @else No Definition Available @endif</span>
                                    <span class="d-block d-md-none"><i class="bi bi-journals"></i></span>
                                </a>
                            </div>
    
                            <div>
                                {{-- <a href="" class="btn py-1 px-2 text-light bg-primary">
                                    <span>Favorites</span>
                                </a> --}}


                                {{-- <span class="mx-1">|</span>
                                <button wire:click="like" class="btn py-1 px-2 bg-primary"><i class="text-light bi bi-star"></i></button> --}}
                                {{-- <button data-bs-toggle="modal" data-bs-target="#sharingsettings" class="btn py-1 px-2 bg-primary"><i class="text-light bi bi-share"></i></button> --}}
                            </div>
                        </div>

                        @if(!$notfound)
                        <div class="mt-3">
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



            
            </div>
        </div>
    </main>

    <audio id="audio" src="{{$audio}}"></audio>
    <script>

        window.addEventListener('contentChanged', event => {
             
            $('#main_content').animate({ //animate element that has scroll
                scrollTop: 0  //for scrolling
            }, 500);
     
            //$('main_content').animate({scrollTop: document.body.scrollHeight},"slow");
        });


        $('.phonetics').click(function(){
            var audio = document.getElementById("audio");
            audio.play();
        });

        var timer = null;
        $('.search').keyup(function(){
            clearTimeout(timer); 
            timer = setTimeout(doStuff, 500)
        });

        $('#searchword').click(function(){
            doStuff();
        });

        
        function doStuff() {
            window.livewire.emit('search');
        }
    </script>


</div>


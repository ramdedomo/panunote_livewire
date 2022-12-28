<div>

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
              <h5 class="modal-title" id="staticBackdropLabel">Share</h5>
              <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>
            <div class="modal-body">

                <div class="d-flex">
                    <div class="w-100">
                        <input id="notesharing" wire:model.defer="urlsharing" class="form-control" type="text" disabled>
                    </div>
                    <div class="mx-2"></div>
                    <div>
                        <button onclick="notecopytoclipboard()" class="btn btn-primary"><i class="bi bi-clipboard"></i></button>
                    </div>
                </div>
        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Done</button>
            </div>
          </div>
        </div>
      </div>


    <main class="">
        <div class="">
            {{-- <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1> --}}
            <div class="sticky-top bg-white p-0 m-0">
                <div class="sizebox"></div>
                <div class="p-3 m-0">
                    <div class="d-flex justify-content-between">
                        <div class="rounded">
                            {{-- <a href="{{ url('subjects/') }}" class="btn py-1 text-light bg-primary"><i class="bi bi-journals"></i></a> --}}

                            <span class="fw-bold text-primary">{{$user_name}}</span> 
                            <span class="mx-1">|</span>
                            <a href="{{ url('subjects/'.$subject_details->subject_id ) }}" class="btn py-1 px-2 text-light bg-primary">
                                <span class="d-none d-md-block">{{ $subject_details->subject_name }}</span>
                                <span class="d-block d-md-none"><i class="bi bi-journals"></i></span>
                            </a>
                            
                            <button disabled class="btn py-1 px-2 text-light bg-primary">
                                <span class="d-none d-md-block">{{ $note_details->note_title }}</span>
                                <span class="d-block d-md-none"><i class="bi bi-journal"></i></span>
                            </button>
                            {{-- <span class="mx-2">|</span> --}}
                        </div>

                        <div class="rounded">
                            <span wire:loading>
                                <div id="spinner" class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0" role="status" aria-hidden="true"></div>
                            </span>
                        
                            <button data-bs-toggle="modal" data-bs-target="#takequiz" class="btn py-1 px-2 bg-primary text-light tooltip-container">
                                Take Quiz
                                <span class="tooltip">Take a quiz from this note's generated quizzes.</span>
                            </button>
   
                            <span class="">|</span>
                            <button data-bs-toggle="modal" data-bs-target="#sharingsettings" class="btn py-1 px-2 bg-primary"><i class="text-light bi bi-share"></i></button>
                            <button wire:click="like" class="btn py-1 px-2 bg-primary"> @if($isfavorite) <i class="text-light bi bi-heart-fill"></i> @else <i class="text-light bi bi-heart"></i> @endif</button>
                            {{-- <button class="btn py-1 px-2 bg-primary"><i class="text-light bi bi-journal-x"></i></button> --}}
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div>
                            <input disabled type="text" wire:model="notetitle" class="notecontroller form-control fs-1 mb-2 p-0 px-2 border-1">
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="badge bg-info"><i class="bi bi-tag-fill"></i></span>
                                @foreach (explode (",", $note_details->note_tags ) as $tag)
                                    <a href="#" class="btn text-light badge bg-info">{{$tag}}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
            
            {{-- <button id="getvalue" class="m-3">get value</button> --}}
            {{-- <button id="getautosave">get saved</button> --}}

            <script src="{{ asset('js/tinymce-public.js') }}"></script>
            <script>tinyMCE.get('noteareaID').setMode('readonly');</script>
            <div class="p-3" wire:ignore>
                <textarea wire:model="notecontent" id="noteareaID"></textarea>
            </div>

        </div>
    </main>
</div>

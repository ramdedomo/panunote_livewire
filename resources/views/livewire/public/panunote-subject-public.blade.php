<div>

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
                        <input id="subjectsharing" wire:model.defer="urlsharing" class="form-control" type="text" disabled>
                    </div>
                    <div class="mx-2"></div>
                    <div>
                        <button onclick="subjectcopytoclipboard()" class="btn btn-primary"><i class="bi bi-clipboard"></i></button>
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
                        <div class="rounded p-1">
                            {{-- <a href="{{ url('subjects/') }}" class="btn py-1 text-light bg-primary"><i class="bi bi-journals"></i></a> --}}

                            {{-- <span class="mx-2">|</span> --}}
                            {{-- <span class="mx-2">|</span> --}}
                            <a href="{{ url('subjects/'.$subject_details->subject_id ) }}" class="btn py-1 px-2 text-light bg-primary">
                                <span class="d-none d-md-block">{{ $subject_details->subject_name }}</span>
                                <span class="d-block d-md-none"><i class="bi bi-journals"></i></span>
                            </a>
                            {{-- <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn py-1 px-2 bg-primary"><i class="text-light bi bi-plus-square"></i></button> --}}
                        </div>

                        <div class="rounded p-1">
                            <span wire:loading>
                                <div id="spinner" class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0" role="status" aria-hidden="true"></div>
                            </span>
                            <button data-bs-toggle="modal" data-bs-target="#sharingsettings" class="btn py-1 px-2 bg-primary"><i class="text-light bi bi-share"></i></button>
                            <button wire:click="like" class="btn py-1 px-2 bg-primary"> @if($isfavorite) <i class="text-light bi bi-heart-fill"></i> @else <i class="text-light bi bi-heart"></i> @endif</button>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div>
                            <input disabled wire:model="subjectname" type="text" class="subjectcontroller form-control fs-1 mb-2 p-0 px-2 border-1">
                        </div>

                        <div class="d-flex justify-content-between">
                            
                            <div>
                                <span class="badge bg-primary"><i class="bi bi-tag-fill"></i></span>
                                <span class="badge bg-primary">Programming</span>
                                <span class="badge bg-primary">Math</span>
                            </div>

                            <span wire:loading wire:target="submit">
                                <span id="spinner" class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0" role="status" aria-hidden="true">
                            </span>

                        </div>


                    </div>
                </div>
            </div>

            <div id="notecontainer" class="row mt-2 p-3">
                @foreach ($notes as $note)
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                    <div class="note-card rounded-3 p-3 card">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="p-0 m-0 mb-2 fw-bold" id="title">{{ $note->note_title }}
                                </p>
                            </div>
                            <div>
                                <p class="p-0 m-0 mb-2" id="title">8/18/2022</p>
                            </div>
                        </div>
                        <p class="p-0 m-0" id="description">
                           {{ substr(str_replace("&nbsp;", " ", Strip_tags($note->note_content)), 0, 150) . '...' }}
                        </p>
                        <a href="{{$subject_details->subject_id}}/{{$note->note_id}}" class="stretched-link"></a>
                    </div>
                </div>
            @endforeach

            </div>
        </div>
    </main>
</div>

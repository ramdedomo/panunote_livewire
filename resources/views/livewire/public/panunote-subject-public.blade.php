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
                        <div class="rounded">
                            {{-- <a href="{{ url('subjects/') }}" class="btn py-1 text-light bg-primary"><i class="bi bi-journals"></i></a> --}}

                            {{-- <span class="mx-2">|</span> --}}
                            <span class="fw-bold text-primary">{{$user_name}}</span> 
                            <span class="mx-1">|</span>
                            <a href="{{ url('subjects/'.$subject_details->subject_id ) }}" class="btn py-1 px-2 text-light bg-primary">
                                <span class="d-none d-md-block">{{ $subject_details->subject_name }}</span>
                                <span class="d-block d-md-none"><i class="bi bi-journals"></i></span>
                            </a>
                            {{-- <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn py-1 px-2 bg-primary"><i class="text-light bi bi-plus-square"></i></button> --}}
                        </div>

                        <div class="rounded">
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
                    </div>
                </div>
            </div>

            <div id="notecontainer" class="row mt-2 p-3">

                @if ($notes->isEmpty())

                <div class="p-3 text-center">
                    <div class="bg-semi-dark rounded-3 border border-1 border-secondary border-opacity-25 p-4 h-100">
                        Wow such Empty :)
                    </div>
                </div>
                @else
                @foreach ($notes as $note)

                  <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <div style="height: 200px"
                                class="card note-card rounded-3 border border-1 border-warning border-opacity-25">
                                
                                <div class="card-header border-bottom border-warning border-2">
                                    <div>
                                        <p class="p-0 m-0 fw-bold" id="title">
                                            {{ substr($note->note_title, 0, 25) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="p-0 m-0" id="title">
                                            {{ date_format($note->updated_at, 'm/d h:i A') }}</p>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <p class="p-0 m-0" id="description">
                                        {{ substr(str_replace('&nbsp;', ' ', Strip_tags($note->note_content)), 0, 100) . ' ...' }}
                                    </p>
                                </div>

                                <a href="{{ $subject_details->subject_id }}/{{ $note->note_id }}"
                                    class="stretched-link"></a>
                            </div>
                        </div>

            @endforeach

                @endif




            </div>
        </div>
    </main>
</div>

<div>
    <div wire:ignore.self class="modal fade" id="deleteSubject" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Are you sure to Delete
                        <strong>{{ $subject_details->subject_name }} (Subject) </strong>?
                    </h5>
                    <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </div>
                <div class="modal-body">

                    <div class="row gy-2 gx-2">

                        <div class="col-4">
                            <div class="bg-semi-dark rounded-3 p-2">
                                <i class="bi bi-question-circle-fill text-primary"></i>
                                <strong>{{ count($notes) }}</strong> Notes
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="bg-semi-dark rounded-3 p-2 align-items-center">
                                <i class="bi bi-heart-fill text-primary"></i> <strong>{{ $subjectlikes_count }}</strong>
                                Public Likes
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="bg-semi-dark rounded-3 p-2">
                                <i class="bi bi-door-open-fill text-primary"></i>
                                <strong>{{ $subjectvisits_count }}</strong> Public Visits
                            </div>
                        </div>


                        <div>
                            <hr class="m-0">
                        </div>

                        <div class="text-center my-2">
                            @if ($errors->any())
                                <span>{{ $errors->first() }}</h4>
                            @endif
                        </div>

                        @if (!$notes->isEmpty())
                            <div x-data="{ not: false, create: true, transfer: false }">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        Preserve Notes
                                    </div>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="preservenote"
                                                @click="create = false, transfer = false, not = true"
                                                class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio1" value="option">
                                            <label class="form-check-label" for="inlineRadio1">Delete</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input wire:model="preservenote"
                                                @click="create = true, transfer = false, not = false"
                                                class="form-check-input" type="radio" name="inlineRadioOptions"
                                                id="inlineRadio1" value="option1">
                                            <label class="form-check-label" for="inlineRadio1">Create</label>
                                        </div>



                                        @if (!$allsubs->isEmpty())
                                            <div class="form-check form-check-inline">
                                                <input wire:model="preservenote"
                                                    @click="create = false, transfer = true, not = false"
                                                    class="form-check-input" type="radio" name="inlineRadioOptions"
                                                    id="inlineRadio2" value="option2">
                                                <label class="form-check-label" for="inlineRadio2">Transfer</label>
                                            </div>
                                        @endif

                                    </div>
                                </div>


                                <div x-show="create" class="input-group mt-2">
                                    <span class="input-group-text" id="basic-addon1">Subject Name</span>
                                    <input wire:model="newsubject" type="text" class="form-control"
                                        aria-describedby="basic-addon1">
                                </div>

                                @if (!$allsubs->isEmpty())
                                    <div x-show="transfer" class="mt-2">
                                        <select wire:model="selectsubject" class="form-select"
                                            aria-label="Default select example">
                                            @foreach ($allsubs as $sub)
                                                <option value="{{ $sub->subject_id }}">{{ $sub->subject_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif

                            </div>
                        @endif

                    </div>

                </div>

                <div class="modal-footer">
                    <button data-bs-dismiss="modal" aria-label="Close" type="button"
                        class="btn bg-secondary text-light">Cancel</button>
                    <button wire:click="delete" type="button" class="btn bg-warning text-light">Delete</button>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="sharingsettings" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Sharing Settings</h5>
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






    <div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">New {{ $subject_details->subject_name }} Notes
                    </h5>
                    <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </div>

                <form wire:submit.prevent="submit">
                    <div class="modal-body">


                        <div>
                            <div class="row gy-2 align-items-center">

                                <div class="">

                                    <div class="progress mb-1 d-none" id="progress_bar">
                                        <div class="progress-bar progress-bar-striped" id="progress-bar-scan"
                                            role="progressbar" aria-label="Basic example" aria-valuenow="100"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Upload Photo:</span>
                                        <input accept="image/png, image/jpeg, image/jpg" type="file"
                                            id="formFile" class="form-control">
                                    </div>

                                    <div class="d-grid mt-2">
                                        <button class="btn btn-primary" id='scanphoto' type="button">Scan</button>
                                    </div>

                                    <div class="mt-2">
                                        <div class="form-floating">
                                            <textarea class="form-control" placeholder="Leave a comment here" id="result_scan" style="height: 50"></textarea>
                                            <label for="result_scan">Note Content</label>
                                        </div>
                                    </div>

                                    <hr>
                                </div>


                                <div>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1"> Note Title:</span>
                                        <input placeholder="@error('notetitle'){{ $message }}@enderror"
                                            type="text" wire:model.defer="notetitle" id="notetitle"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-10">
                                    @error('notetags')
                                        <span class="error">{{ $message }}</span>
                                    @enderror

                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Tags:</span>
                                        <input type="text" wire:model.defer="notetags" id="notetags"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="col-2">
                                    @error('notesharing')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" role="switch" type="checkbox"
                                            wire:model.defer="notesharing" id="notesharing" data-onstyle="primary">
                                        <label class="form-check-label" for="notesharing">Public</label>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <main class="">
        <div class="">
            {{-- <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1> --}}
            <div class="sticky-top bg-white p-0 m-0 border-bottom border-2 border-primary">
                <div class="sizebox"></div>
                <div class="p-3 m-0">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ url('subjects/') }}" class="btn py-1 text-light bg-primary"><i
                                    class="bi bi-journals"></i> Subjects</a>

                            <span>|</span>
                            {{-- <span class="mx-2">|</span> --}}
                            <a href="{{ url('subjects/' . $subject_details->subject_id) }}"
                                class="btn py-1 px-2 text-light bg-primary disabled">
                                <span class="d-none d-md-block">{{ $subject_details->subject_name }}</span>
                                <span class="d-block d-md-none"><i class="bi bi-journals"></i></span>
                            </a>

                            
                            <button data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn py-1 px-2 bg-primary">
                                <span class="d-none d-lg-block text-light">
                                    <i class="bi bi-plus-square"></i>&nbsp; Create Note
                                </span>

                                <span class="d-block d-lg-none text-light">
                                    <i class="bi bi-plus-square"></i>
                                </span>
                            </button>
                        </div>

                        <div>
                            <span wire:loading>
                                <div id="spinner"
                                    class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0" role="status"
                                    aria-hidden="true"></div>
                            </span>
                            <button data-bs-toggle="modal" data-bs-target="#sharingsettings"
                                class="btn py-1 px-2 bg-primary"><i class="text-light bi bi-share"></i>&nbsp;<span
                                    class="text-light">Share</span></button>
                            <button wire:click="like" class="btn py-1 px-2 bg-primary">
                                @if ($isfavorite)
                                    <i class="text-light bi bi-heart-fill"></i>
                                @else
                                    <i class="text-light bi bi-heart"></i>
                                @endif
                            </button>
                            <span>|</span>
                            <button data-bs-toggle="modal" data-bs-target="#deleteSubject"
                                class="btn py-1 px-2 bg-warning"><i class="text-light bi bi-journal-x"></i></button>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div>
                            <input wire:model="subjectname" type="text"
                                class="subjectcontroller form-control fs-1 mb-2 p-0 px-2 border-1">
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="d-flex justify-content-between">
                            <div class="py-1 rounded-3 d-flex align-items-center justify-content-center">

                                <span class="badge bg-warning">{{ count($notes) }} Notes</span>


                            </div>

                            <div class="d-flex" wire:ignore>
                                <div class="input-group first">
                                    <select wire:model="sort" class="form-select"
                                        aria-label="Default select example">
                                        <option value="" selected disabled hidden>Sort</option>
                                        <option value="lto">Latest to Oldest</option>
                                        <option value="otl">Oldest to Latest</option>
                                        <option value="atz">A - Z</option>
                                        <option value="zta">Z - A</option>
                                    </select>
                                </div>
                                <span class="mx-1"></span>
                                <div>
                                    <input wire:model="search" style="width: 150px" class="form-control"
                                        type="text" placeholder="Search" aria-label="default input example">
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>


            <div id="notecontainer" class="row mt-2 p-3">

                @if ($notes->isEmpty())

                    <div class="p-3 text-center">
                        <div
                            class="bg-semi-dark rounded-3 border border-1 border-secondary border-opacity-25 p-4 h-100">
                            <i class="bi bi-info-circle-fill"></i> &nbsp;To Create Notes, Click <strong>Create
                                Note</strong> Above
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



                <script>
                    $(".subjectcontroller").change(function() {
                        window.livewire.emit('set:save');
                    });

                    document.addEventListener('keydown', (e) => {
                        if (e.ctrlKey && String.fromCharCode(e.keyCode).toLowerCase() === 's') {
                            e.preventDefault();
                            e.stopPropagation();
                            window.livewire.emit('set:save');
                        }
                    }, false);

                    document.addEventListener('livewire:load', function() {
                        $(document).ready(function() {
                            $("#scanphoto").click(function() {
                                var a = $('#formFile')[0].files[0];
                                document.getElementById('progress-bar-scan').style.width = '0%';
                                $("#progress_bar").removeClass("d-none")

                                Tesseract.recognize(
                                    a,
                                    'eng', {
                                        logger: message => {
                                            if (message.status == "recognizing text") {
                                                document.getElementById('progress-bar-scan').style
                                                    .width = (message.progress * 100) + '%';
                                            }
                                        }
                                    }
                                ).then(({
                                    data: {
                                        text
                                    }
                                }) => {
                                    document.getElementById("result_scan").value = text;
                                    $("#progress_bar").addClass("d-none")
                                    @this.notecontent = text;
                                })

                            });
                        });
                    })
                </script>


            </div>
        </div>
    </main>
</div>

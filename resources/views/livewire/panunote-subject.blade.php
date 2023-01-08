<div>
    <div wire:ignore.self class="modal fade" id="deleteSubject" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content" x-data="{ not: false, create: true, transfer: false }">
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
                            <div>
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

                    <button wire:click="delete" type="button" class="btn bg-warning text-light">
                        @if ($note_list->isEmpty())
                            <span>Delete</span>
                        @else
                            <span x-show="not">Delete</span>
                            <span x-show="create">Create</span>
                            <span x-show="transfer">Transfer</span>
                        @endif
                    </button>

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
                    <h5 class="modal-title" id="staticBackdropLabel">Create Note
                    </h5>
                    <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </div>

                <form wire:submit.prevent="submit">
                    <div class="modal-body">


                        <div>
                            <div class="row gy-2 align-items-center">

                                <div class="">

                                    <div class="bg-semi-dark p-2 rounded text-secondary text-center mb-2">
                                        <i class="bi bi-info-circle"></i> Upload Document Photo Here
                                        (Optional)</strong>
                                    </div>

                                    <div class="progress mb-1 d-none" id="progress_bar">
                                        <div class="progress-bar progress-bar-striped" id="progress-bar-scan"
                                            role="progressbar" aria-label="Basic example" aria-valuenow="100"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>

                                    <div class="d-flex">
                                        <div class="input-group">
                                            <input accept="image/png, image/jpeg, image/jpg" type="file"
                                                id="formFile" class="form-control">
                                        </div>

                                        <span class="mx-1"></span>

                                        <div class="d-grid">
                                            <button class="btn btn-primary py-1" id='scanphoto'
                                                type="button">Scan</button>
                                        </div>
                                    </div>


                                    <div class="mt-2">
                                        <div class="form-floating">
                                            <textarea wire:model="notecontent" class="form-control" placeholder="Leave a comment here" id="result_scan"
                                                style="height: 50"></textarea>
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

                                <div>
                                    <div class="bg-semi-dark p-2 rounded text-secondary text-center">
                                        <i class="bi bi-info-circle"></i> Seperate Tags using <strong>","</strong>
                                        &nbsp;&nbsp; / &nbsp;&nbsp; <strong>Example: Panunote,Panugame</strong>
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



    <div wire:ignore.self class="modal fade" id="movecopy" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modify Selected</h5>
                    <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </div>
                <div class="modal-body">

                    @if (count($itemsCard) == 0)
                        <div class="card p-2 bg-semi-dark rounded mb-2">
                            <div class="d-flex justify-content-center align-items-center">
                                <span>Please Select Notes</span>
                            </div>
                        </div>
                    @else
                        <div class="card p-2 bg-semi-dark rounded mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span>No. of Selected Notes</span>
                                <span class="fw-bold">{{ count($itemsCard) }} Notes</span>
                            </div>
                        </div>
                    @endif


                    <div class="panel panel-primary" id="result_panel">
                        <div class="panel-body">
                            <ul class="list-group"
                                style="
                         max-height: 200px;
                        margin-bottom: 10px;
                        overflow-y:auto;
                        -webkit-overflow-scrolling: touch;
                        ">

                                @foreach ($itemsCard as $note)
                                    <li class="list-group-item">
                                        <strong>{{ explode(',', $note)[1] }}</strong>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>





                    @if (!$allsubs->isEmpty())
                        <div class="p-2 mb-2 rounded-3 bg-semi-dark">
                            <div>
                                Select Subject:
                                <select wire:model="selectsubject" class="form-select"
                                    aria-label="Default select example">
                                    @foreach ($allsubs as $sub)
                                        <option value="{{ $sub->subject_id }}">{{ $sub->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="card p-2 bg-semi-dark rounded mb-2">
                            <div class="d-flex justify-content-center align-items-center">
                                <span>No Available Subjects - <a href="{{ route('subjects') }}">Create Here
                                        First</a></span>
                            </div>
                        </div>
                    @endif



                </div>
                <div class="modal-footer">
                    <div class="d-flex justify-content-between w-100">
                        <div>
                            <button wire:click="delete_selected" type="button"
                                class="btn bg-warning text-light @if (count($itemsCard) == 0) disabled @endif">Delete
                                Selected</button>
                        </div>
                        <div>
                            <button wire:click="duplicate_selected" type="button"
                                class="btn btn-primary @if (count($itemsCard) == 0 || $allsubs->isEmpty()) disabled @endif"><i
                                    class="bi bi-stickies-fill"></i> Duplicate</button>

                            <button wire:click="move_selected" type="button"
                                class="btn btn-primary @if (count($itemsCard) == 0 || $allsubs->isEmpty()) disabled @endif"><i
                                    class="bi bi-arrow-right-square"></i> Move</button>
                            <button wire:click="copy_selected" type="button"
                                class="btn btn-primary @if (count($itemsCard) == 0 || $allsubs->isEmpty()) disabled @endif"><i
                                    class="bi bi-clipboard"></i> Copy</button>

                    
        

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="copysingle" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Copy</h5>
                    <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </div>
                <div class="modal-body">


                    <div wire:ignore class="card p-2 bg-semi-dark rounded mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Selected Note</span>
                            <span class="selectednote fw-bold"></span>
                        </div>
                    </div>


                    @if (!$allsubs->isEmpty())
                        <div class="p-2 mb-2 rounded-3 bg-semi-dark">
                            <div>
                                Select Subject:
                                <select wire:model="selectsubject" class="form-select"
                                    aria-label="Default select example">
                                    @foreach ($allsubs as $sub)
                                        <option value="{{ $sub->subject_id }}">{{ $sub->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="card p-2 bg-semi-dark rounded mb-2">
                            <div class="d-flex justify-content-center align-items-center">
                                <span>No Available Subjects - <a href="{{ route('subjects') }}">Create Here
                                        First</a></span>
                            </div>
                        </div>
                    @endif



                </div>
                <div class="modal-footer">
                    <div>
                        <div>
                            <button wire:click="copy_single" type="button" class="btn btn-primary  @if ($allsubs->isEmpty()) disabled @endif"><i
                                    class="bi bi-clipboard"></i> Copy</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="movesingle" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Move</h5>
                    <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </div>
                <div class="modal-body">


                    <div wire:ignore class="card p-2 bg-semi-dark rounded mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Selected Note</span>
                            <span class="selectednote fw-bold"></span>
                        </div>
                    </div>


                    @if (!$allsubs->isEmpty())
                        <div class="p-2 mb-2 rounded-3 bg-semi-dark">
                            <div>
                                Select Subject:
                                <select wire:model="selectsubject" class="form-select"
                                    aria-label="Default select example">
                                    @foreach ($allsubs as $sub)
                                        <option value="{{ $sub->subject_id }}">{{ $sub->subject_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @else
                        <div class="card p-2 bg-semi-dark rounded mb-2">
                            <div class="d-flex justify-content-center align-items-center">
                                <span>No Available Subjects - <a href="{{ route('subjects') }}">Create Here
                                        First</a></span>
                            </div>
                        </div>
                    @endif



                </div>
                <div class="modal-footer">
                    <div>
                        <div>
                            <button wire:click="move_single" type="button" class="btn btn-primary @if ($allsubs->isEmpty()) disabled @endif"><i
                                    class="bi bi-arrow-right-square"></i> Move</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <main class="">
        <div class="" x-data="{
            options: false,
            selectAll: false,
            itemsCard: @entangle('itemsCard'),
        
            selectAllCheckboxes() {
                this.selectAll = !this.selectAll;
             
                let checkboxes = document.querySelectorAll('.item-select-input');
                let allValues = [];
        
                [...checkboxes].map((el) => {
                    allValues.push(el.value)
                    this.itemsCard = this.selectAll ? allValues : []
                })
            }
        
        }">


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


                            <button data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                class="btn py-1 px-2 bg-primary">
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
                                class="border-3 border-bottom border-primary subjectcontroller form-control fs-1 mb-2 p-0 px-2 border-1">
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="d-flex justify-content-between">
                            <div class="py-1 rounded-3 d-flex align-items-center justify-content-center">

                                <span class="badge bg-warning">{{ count($notes) }} Notes</span>


                            </div>

                            <div class="d-flex" wire:ignore>

                                <div class="align-items-center" x-show="options" x-transition>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <input class="form-check-input" id="selectAllItems" type="checkbox"
                                                x-on:click="selectAllCheckboxes">
                                            <label class="form-check-label" for="selectAllItems">
                                                Select All
                                            </label>
                                        </div>

                                        <span class="mx-1"></span>


                                        <button data-bs-toggle="modal" data-bs-target="#movecopy"
                                            class="btn btn-primary">Modify Selected</button>
                                    </div>

                                </div>


                                <span class="mx-1"></span>

                                <button @click="options = ! options"
                                    :class="options ? 'px-2 btn btn-secondary tooltip-container' :
                                        'px-2 btn btn-primary tooltip-container'">
                                    <span x-show="!options">
                                        <i class="bi bi-gear"></i>
                                    </span>
                                    <span x-show="options">
                                        <i class="bi bi-x-circle"></i>
                                    </span>
                                </button>

                                <span class="mx-1"></span>
                                <div class="input-group first">
                                    <select :disabled="options" wire:model="sort" class="form-select"
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
                                    <input :disabled="options" wire:model="search" style="width: 150px"
                                        class="form-control" type="text" placeholder="Search"
                                        aria-label="default input example">
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>


            <div id="notecontainer" class="row mt-2 p-3">

                @if ($notes->isEmpty() && empty($search))
                    <div class="p-3 text-center">
                        <div
                            class="bg-semi-dark rounded-3 border border-1 border-secondary border-opacity-25 p-4 h-100">
                            <i class="bi bi-info-circle-fill"></i> &nbsp;To Create Notes, Click <strong>Create
                                Note</strong> Above
                        </div>
                    </div>
                @elseif($notes->isEmpty() && !empty($search))
                    <div class="p-3 text-center">
                        <div
                            class="bg-semi-dark rounded-3 border border-1 border-secondary border-opacity-25 p-4 h-100 fw-bold">
                            <i class="bi bi-search"></i> Not Found
                        </div>
                    </div>
                @else
                    @foreach ($notes as $note)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <div style="height: 200px"
                                :class="options ?
                                    'mb-2 card note-card rounded-3 border border-1 border-warning border-opacity-25' :
                                    'card note-card rounded-3 border border-1 border-warning border-opacity-25'"
                                class="">

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

                            <div class="mb-3 p-2 bg-semi-dark rounded-3 border border-1 border-warning border-opacity-25"
                                x-transition x-show="options">
                                <div class="d-flex justify-content-between" x-data="{isselected: false}">
                                    <div class="d-flex">

                                        <button wire:ignore wire:click="delete_single({{ $note->note_id }})"
                                            class="btn bg-warning text-light px-2" title="Delete">
                                            <i class="bi bi-journal-x"></i>
                                        </button>

                                        <span class="mx-1"></span>

                                        <button wire:ignore wire:click="duplicate_single({{ $note->note_id }})"
                                            class="buttonmodify btn btn-primary" title="Duplicate">
                                            <i class="bi bi-stickies-fill"></i>
                                        </button>

                                        <span class="mx-1"></span>

                                        <button wire:ignore
                                            onclick="modifyselect('{{ $note->note_id }}', '{{ $note->note_title }}')"
                                            data-bs-toggle="modal" data-bs-target="#movesingle"
                                            class="buttonmodify btn btn-primary" title="Move">
                                            <i class="bi bi-arrow-right-square"></i>
                                        </button>

                                        <span class="mx-1"></span>

                                        <button wire:ignore
                                            onclick="modifyselect('{{ $note->note_id }}', '{{ $note->note_title }}')"
                                            data-bs-toggle="modal" data-bs-target="#copysingle"
                                            class="buttonmodify btn btn-primary" title="Copy">
                                            <i class="bi bi-clipboard"></i>
                                        </button>


                                    </div>

                                    <div class="d-flex align-items-center">
                                        <div class="form-check">
                                            <input @click="isselected = ! isselected" class="item-select-input form-check-input" type="checkbox"
                                                value='{{ $note->note_id }}, {{ $note->note_title }}'
                                                x-model="itemsCard">
                                        </div>

                                    </div>
                             


                                </div>

                            </div>
                        </div>
                    @endforeach
                @endif

                <script>
                    function modifyselect(id, title) {
                        @this.singleSelectid = id;
                        $(".selectednote").text(title);
                    }

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
                                var fileType = a["type"];
                                var validImageTypes = ["image/gif", "image/jpeg", "image/png"];
                                if ($.inArray(fileType, validImageTypes) < 0) {
                                    $(".content-toast").text('Please Pick a Image.');
                                    const toast = new bootstrap.Toast($('#liveToast'));
                                    toast.show();
                                } else {
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
                                }


                            });



                        });

                    })

                    // document.addEventListener('alpine:init', () => {
                   
                    //     Alpine.data('checkboxes', () => ({
                    //         selectAll: false,
                    //         itemsCard: [],

                    //         selectAllCheckboxes() {
                    //             this.selectAll = !this.selectAll

                    //             let checkboxes = document.querySelectorAll('.item-select-input');
                    //             let allValues = [];

                    //             [...checkboxes].map((el) => {
                    //                 allValues.push(el.value)
                    //                 this.itemsCard = this.selectAll ? allValues : []
                    //             })
                    //         }
                    //     }))
                    // });
                </script>


            </div>
        </div>
    </main>
</div>

<div>


    <div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Subject</h5>
                    <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </div>

                <form wire:submit.prevent="submit">
                    <div class="modal-body">
                        <div>
                            <div class="row gy-3 align-items-center">

                                <div class="col-10">
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">Subject Title:</span>
                                        <input placeholder="@error('subjecttitle'){{ $message }}@enderror"
                                            type="text" wire:model="subjecttitle" id="subjecttitle"
                                            class="form-control form-control-sm">
                                    </div>
                                </div>


                                <div class="col-2">
                                    <div class="form-check form-switch">
                                        @error('subjectsharing')
                                            <span class="error">{{ $message }}</span>
                                        @enderror
                                        <input class="form-check-input" role="switch" type="checkbox"
                                            wire:model="subjectsharing" id="subjectsharing" data-onstyle="primary">
                                        <label class="form-check-label" for="subjectsharing">Public</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <main class="">
        <div class="">
            {{-- <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1> --}}
            <div class="bg-white p-0 m-0 border-bottom border-2 border-primary">
                <div class="sizebox"></div>
                <div class="p-3 m-0">
                    <div class="d-flex justify-content-between mb-2">

                        <div>
                            <a href="{{ url('subjects/') }}" class="disabled btn py-1 text-light bg-primary"><i
                                class="bi bi-journals"></i> Subjects</a>

                        <span>|</span>
                            <button data-bs-toggle="modal" data-bs-target="#staticBackdrop"
                                class="btn text-light bg-primary">

                                <span wire:loading wire:target="submit">
                                    <span id="spinner"
                                        class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                                        role="status" aria-hidden="true"></span>
                                </span>

                                <span class="d-none d-lg-block">
                                    <i class="bi bi-plus-square"></i>&nbsp; Create Subject
                                </span>

                                <span class="d-block d-lg-none">
                                    <i class="bi bi-plus-square"></i>
                                </span>

                            </button>
                        </div>

                        <div class="d-flex" wire:ignore>

                            <div class="input-group first">
                                <select wire:model="sort" class="form-select" aria-label="Default select example">
                                    <option value="" selected disabled hidden>Sort</option>
                                    <option value="lto">Latest to Oldest</option>
                                    <option value="otl">Oldest to Latest</option>
                                    <option value="atz">A - Z</option>
                                    <option value="zta">Z - A</option>
                                </select>
                            </div>

                            <div class="mx-1"></div>
                            <div>
                                <input wire:model="search" style="width: 150px" class="form-control" type="text"
                                    placeholder="Search" aria-label="default input example">
                            </div>

                        </div>


                    </div>
                </div>
            </div>
            


            <div id="subjectcontainer" class="row p-3">

                @if ($subjects->isEmpty() && empty($search))
                    <div class="p-3 text-center">
                        <div class="bg-semi-dark rounded-3 border border-1 border-secondary border-opacity-25 p-4 h-100">
                            <i class="bi bi-info-circle-fill"></i> &nbsp;To Create Subject, Click <strong>Create Subject</strong> Above
                        </div>
                    </div>
                @elseif($subjects->isEmpty() && !empty($search))
                <div class="p-3 text-center">
                    <div class="bg-semi-dark rounded-3 border border-1 border-secondary border-opacity-25 p-4 h-100 fw-bold">
                        <i class="bi bi-search"></i> Not Found
                    </div>
                </div>

                @else
                    @foreach ($subjects as $subject)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <div class="card note-card rounded-3 border border-1 border-primary border-opacity-25">
                                <div
                                    class="card-header border-bottom border-primary border-2">
                                    <div>
                                        <p class="p-0 m-0 fw-bold" id="title">
                                            {{ substr($subject->subject_name, 0, 25) }}
                                      
                                        </p>
                                    </div>
                                    <div>
                                        <p class="p-0 m-0" id="title">
                                            {{ date_format($subject->updated_at, 'm/d h:i A') }}
                                        
                                        </p>
                                    </div>
                                </div>

                       


                                <div class="card-body">
                                    @php
                                        $count = 0;
                                    @endphp
                                    @foreach ($subject->notes as $notes)
                                        @if ($count++ == 2)
                                            @if ($count == count($subject->notes))
                                                <span class="badge text-bg-primary">{{ $count - 2 }}+</span>
                                            @endif
                                        @else
                                            <span class="badge text-bg-primary">{{ $notes->note_title }}</span>
                                        @endif
                                    @endforeach

                                    @if (count($subject->notes) == 0)
                                        <span class="badge text-secondary w-100">Empty</span>
                                    @endif
                                </div>


                                <a href="{{ url('subjects/' . $subject->subject_id) }}" class="stretched-link"></a>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
    </main>
</div>

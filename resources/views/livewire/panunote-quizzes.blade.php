<div>
    <div wire:ignore.self class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Create Quiz</h5>
                    <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </div>

                <div class="modal-body">
                    <div class="row align-items-center">

                        <div class="col-4 mb-3" wire:ignore>
                            Tags: <br>
                            <select wire:model="quizcreate_tags" data-width="100%"class="selectpicker"
                                data-live-search="true" multiple data-selected-text-format="count"
                                data-actions-box="true">
                                @foreach ($tags as $t)
                                    <option data-tokens="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-4 mb-3" wire:ignore>
                            Difficulty: <br>
                            <select wire:model="quizcreate_diff" data-width="100%" class="selectpicker" multiple
                                data-selected-text-format="count" data-actions-box="true">
                                @foreach ($question_diff as $q)
                                    @php
                                        $q_string = '';
                                    @endphp
                                    @if ($q == 1)
                                        @php
                                            $q_string = 'Easy';
                                        @endphp
                                    @elseif ($q == 2)
                                        @php
                                            $q_string = 'Intermediate';
                                        @endphp
                                    @elseif ($q == 3)
                                        @php
                                            $q_string = 'Difficult';
                                        @endphp
                                    @endif
                                    <option value="{{ $q }}" data-tokens="{{ $q_string }}">
                                        {{ $q_string }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-4 mb-3" wire:ignore>
                            Max No. of Questions: <br>
                            <select class="selectpicker" title="Nothing Selected" wire:model="quizcreate_count"
                                data-width="100%">
                                <option value="1" data-tokens="1">5</option>
                                <option value="2" data-tokens="2">10</option>
                                <option value="3" data-tokens="3">15</option>
                                <option value="4" data-tokens="4">20</option>
                            </select>
                        </div>

                        <div class="mb-2">
                            <div class="bg-semi-dark p-2 rounded-3 border border-1" style="font-size: 12px">
                                <ul class="m-0">
                                    <li>Single Precision <strong>(Recommended)</strong> - Individually search the selected Tags in a certain Quiz.</li>
                                    <li>Half Precision - Partially search the selected Tags in a certain Quiz.</li>
                                    <li>Full Precision - Fully search the selected Tags in a certain Quiz.</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-6" wire:ignore>
                            Tags Precision: <br>
                            <select class="selectpicker" title="Nothing Selected" wire:model="quizcreate_precision"
                                data-width="100%">
                                <option value="1" data-tokens="Single">Single Precision</option>
                                <option value="2" data-tokens="Half">Half Precision</option>
                                <option value="3" data-tokens="Full">Full Precision</option>
                            </select>
                        </div>

                        <div class="col-6" wire:ignore>
                            Question Sorting:<br>
                            <select class="selectpicker" title="Nothing Selected" wire:model="quizcreate_sorting"
                                data-width="100%">
                                <option value="1" data-tokens="Randomize">Randomize</option>
                                <option value="2" data-tokens="Ascending">Ascending (Difficulty)</option>
                                <option value="3" data-tokens="Descending">Descending (Difficulty)</option>
                            </select>
                        </div>




                        <div class="row align-items-center">
                            <div class="col-10">
                                <br>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">Quiz Title</span>
                                    <input wire:model="quizcreate_title" type="text" class="form-control"
                                        placeholder="Quiz Title">
                                </div>
                            </div>

                            <div class="col-2">
                                <div class="form-check form-switch">
                                    <br>
                                    <input class="form-check-input" role="switch" type="checkbox"
                                        wire:model="quizcreate_sharing" id="quizcreate_sharing" data-onstyle="primary">
                                    <label class="form-check-label" for="quizcreate_sharing">Public</label>
                                </div>
                            </div>


                        </div>





                    </div>



                </div>

                <div class="w-100 modal-footer justify-content-between">

                    <div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                    <div>

                        <button type="submit" wire:click="create_quiz_empty" class="btn btn-primary tooltip-container">
                            Create Empty Quiz &nbsp;<i class="bi bi-journal"></i>
                            <span class="tooltip me-4">
                                Requires Quiz Title
                            </span>
                        </button>


                        <button type="submit" wire:click="create_quiz" class="btn btn-primary tooltip-container">Create Quiz &nbsp;<i
                                class="bi bi-journal-text"></i>
                                <span class="tooltip">
                                    Requires All Field
                                </span>
                            
                            </button>
                    </div>


                </div>

            </div>
        </div>
    </div>

    <main class="">
        <div class="">
            <div class="bg-white p-0 m-0 border-bottom border-2 border-primary">
                <div class="sizebox"></div>
                <div class="p-3 m-0">
                    <div class="d-flex justify-content-between mb-2">
                        <div>

                            <a href="{{ url('quizzes/') }}" class="disabled btn py-1 text-light bg-primary"><i
                                    class="bi bi-question-square"></i> Quizzes</a>

                            <span>|</span>
                            <button data-bs-toggle="modal"
                                data-bs-target="#staticBackdrop"class="btn py-1 text-light bg-primary">

                                <span wire:loading wire:target="submit">
                                    <span id="spinner"
                                        class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                                        role="status" aria-hidden="true">
                                    </span>
                                </span>

                                <span class="d-none d-lg-block text-light">
                                    <i class="bi bi-plus-square"></i>&nbsp; Create Quiz
                                </span>

                                <span class="d-block d-lg-none text-light">
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

            <div id="quizcontainer" class="row p-3">


                @if ($quizzes->isEmpty() && empty($search))
                    <div class="p-3 text-center">
                        <div
                            class="bg-semi-dark rounded-3 border border-1 border-secondary border-opacity-25 p-4 h-100">
                            <i class="bi bi-info-circle-fill"></i> &nbsp;To Create Quiz, Click <strong>Create
                                Quiz</strong> Above
                        </div>
                    </div>
                @elseif($quizzes->isEmpty() && !empty($search))
                    <div class="p-3 text-center">
                        <div
                            class="bg-semi-dark rounded-3 border border-1 border-secondary border-opacity-25 p-4 h-100 fw-bold">
                            <i class="bi bi-search"></i> Not Found
                        </div>
                    </div>
                @else
                    @foreach ($quizzes as $quiz)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                            <div class="card note-card rounded-3 border border-1 border-info border-opacity-25">
                                <div class="card-header border-bottom border-info border-2">
                                    <div>
                                        <p class="p-0 m-0 fw-bold" id="title">
                                            {{ substr($quiz->quiz_title, 0, 25) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="p-0 m-0" id="title">
                                            {{ date_format($quiz->updated_at, 'm/d h:i A') }}
                                        </p>
                                    </div>
                                </div>



                                <div class="card-body">
                                    <span class="fw-bold">{{ $quiz->quiz_count }} Items</span>
                                </div>

                                <a href="{{ url('quizzes/' . $quiz->quiz_id) }}" class="stretched-link"></a>
                            </div>
                        </div>
                    @endforeach
                @endif



            </div>


        </div>
    </main>
</div>

<div>
    <main>
        <div>
            <div class="p-3 p-md-5 p-lg-5">

                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <img class="mb-3" style="width: 200px;" src="{{ asset('img/logos/panugame_logo.png') }}"
                            alt="">
                    </div>

                    <div>
                        <a href="/panugame" type="button" class="btn btn-outline-light"><i
                                class="bi bi-arrow-left-circle"></i> Go Back</a>
                    </div>
                </div>


                <hr class="text-light my-1">

                <div>
                    {{-- @if (!$isjoined) --}}
                    <div class="row rounded">

                        <div class="col-md-4 col-sm-12 my-2">
                            <div class="bg-light rounded p-2">
                                {{-- <p class="fw-bold py-1 m-0">Create Quiz:</p>
                                <hr class="my-0 mb-2"> --}}
                                <a href="{{ route('join') }}" class="text-decoration-none text-light">
                                    <div class="fs-1 p-1 rounded-3 shadow-sm text-center join_btn">
                                        Join Instead
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-8 col-sm-12 my-2">
                            <div class="bg-light rounded p-2">
                                <p class="fw-bold py-1 m-0">Create:</p>
                                <hr class="my-0 mb-2">
                                <form wire:submit.prevent="create">
                                    <div class="row">
                                        <div class="col-6">
                                            Description:
                                            @error('createDescription')
                                                {{ $message }}
                                            @enderror
                                            <input placeholder='' wire:model.defer="createDescription" type="text"
                                                class="bg-light form-control mb-2">
                                        </div>

                                        <div class="col-6">
                                            Public:
                                            @error('privatePass')
                                                {{ $message }}
                                            @enderror
                                            <div class="input-group mb-3">
                                                <div class="input-group-text">
                                                    <input wire:click="isPublic" wire:model.defer="isPublic" checked
                                                        class="form-check-input mt-0" type="checkbox">
                                                </div>


                                                <input @if ($isReadonly) disabled @endif
                                                wire:model.defer="privatePass" placeholder='password' type="text"
                                                    class="form-control" aria-label="Text input with checkbox">
                                            </div>
                                        </div>


                                        <div class="col-3">
                                            Quiz:
                                            @if (!empty($quiz_list))
                                                <select wire:model.defer="quizSelect" class="form-select"
                                                    aria-label="Default select example">
                                                    @foreach ($quiz_list as $quiz)
                                                        <option value="{{ $quiz->quiz_id }}">{{ $quiz->quiz_title }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" disabled class="form-control" value="No Available Quizzes">
                                            @endif

                                        </div>

                                        <div class="col-3">
                                            Capacity:
                                            <select wire:model.defer="capaSelect" class="form-select"
                                                aria-label="Default select example">
                                                <option value="0">5 Players</option>
                                                <option value="1">10 Players</option>
                                                <option value="2">15 Players</option>
                                            </select>
                                        </div>

                                        <div class="col-3">
                                            Time per question:
                                            <select wire:model.defer="timeSelect" class="form-select"
                                                aria-label="Default select example">
                                                <option value="0">20 Seconds</option>
                                                <option value="1">40 Seconds</option>
                                                <option value="2">60 Seconds</option>
                                            </select>
                                        </div>

                                        <div class="col-3">
                                            Difficulty:
                                            <select wire:model.defer="diffSelect" class="form-select"
                                                aria-label="Default select example">
                                                <option value="0">Easy</option>
                                                <option value="1">Intermediate</option>
                                                <option value="2">Hard</option>
                                            </select>
                                        </div>

                                        @if (!empty($quiz_list))
                                        <div class="mt-2">
                                            <div class="d-none d-md-block">
                                                <button class="btn btn-primary">Create</button>
                                            </div>

                                            <div class="d-block d-md-none">
                                                <button class="btn btn-primary w-100">Create</button>
                                            </div>
                                        </div>
                                        @else
                                        <div>
                                            <div class="p-2 bg-primary rounded-3 text-white my-2 d-flex align-items-center justify-content-between">

                                                <div>
                                                    <i class="bi bi-info-circle-fill"></i> &nbsp; Create a Quiz First. 
                                                </div>
                                                <div>
                                                    <a class="btn btn-light" href="{{route('quizzes')}}">Go to Quiz</a>
                                                </div>
                                             
                                              
                                            </div>
                                        </div>

                                        @endif

                                    </div>
                                </form>
                            </div>
                        </div>


                    </div>
                    {{-- @else
                    <div class="p-5 d-flex justify-content-center align-items-center">
                        It looks like you're already in an ongoing game.
                        <div wire:click="rejoin({{$alreadyjoinedid}})" class="mx-2"><button class="btn btn-sm btn-primary">Join</button></div>
                    </div>
                    @endif --}}

                </div>

            </div>
        </div>
    </main>


</div>

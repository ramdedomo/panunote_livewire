<div>
    <main class="">
        <div class="">
            <div class="sticky-top bg-white p-0 m-0">
                <div class="sizebox"></div>


                {{-- 
                <div class="p-3 m-0">

                </div> --}}

            </div>

            <div class="p-3">

                <div class="row row-cols-1 row-cols-md-2">

                    <div class="col">
                        <div class="card panunote-elements">
                            <img src="{{ asset('img/logos/panugame_element3.png') }}" class="card-img-top" alt="...">
                            <div class="card-body">

                                <div class="mb-2">
                                    <i class="bi bi-journals text-primary fs-4"></i>

                                    <span class="card-title text-primary fs-4">Discover Top Subjects</span>
                                </div>


                                <p class="card-text">This is a longer card with supporting text below as
                                    a natural lead-in to additional content. This content is a little
                                    bit longer.</p>
                                <a href="/browse/subjects" class="stretched-link"></a>
                            </div>

                        </div>
                    </div>

                    <div class="col">
                        <div class="card panunote-elements">
                            <img src="{{ asset('img/logos/panugame_element4.png') }}" class="card-img-top"
                                alt="...">
                            <div class="card-body">

                                <div class="mb-2">
                                    <i class="bi bi-journal-text text-primary fs-4"></i>

                                    <span class="card-title text-primary fs-4">Discover Top Notes</span>
                                </div>


                                <p class="card-text">This is a longer card with supporting text below as
                                    a natural lead-in to additional content. This content is a little
                                    bit longer.</p>
                                <a href="/browse/notes" class="stretched-link"></a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="p-2 d-flex justify-content-between rounded-3 bg-semi-dark mb-2">
                    <div>
                        <div class="d-flex">
                            <input wire:model.debounce.500ms="search" class="search form-control" type="text"
                                placeholder="Find Subjects, Note and Quiz" aria-label="default input example">
                            <span class="mx-1"></span>

                            <button id="searchword" class="py-1 px-2 btn btn-primary">
                                <span wire:loading>
                                    <div id="spinner"
                                        class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                                        role="status" aria-hidden="true"></div>
                                </span>
                                <i wire:loading.remove class="bi bi-search"></i>
                            </button>

                        </div>
                    </div>


                    <div>
                        <div class="btn-group">
                            <a wire:click="topsubjects('weekly')"
                                @if ($weekly) class='btn btn-primary active'
                            @else
                            class='btn btn-primary' @endif
                                aria-current="page">
                                This Week</a>


                            <a wire:click="topsubjects('monthly')"
                                @if ($monthly) class='btn btn-primary active'
                            @else
                            class='btn btn-primary' @endif
                                aria-current="page">
                                This Month</a>

                            <a wire:click="topsubjects('yearly')"
                                @if ($yearly) class='btn btn-primary active'
                            @else
                            class='btn btn-primary' @endif
                                aria-current="page">
                                This Year</a>
                        </div>
                    </div>
                </div>

                <div class="p-2 d-flex border-bottom border-3 border-primary align-items-center rounded-3 justify-content-center bg-semi-dark mb-5">
                    <div class="text-secondary w-100">
                        @if ($subjects->isEmpty() && $notes->isEmpty() && $quizzes->isEmpty() && !empty($this->search))
                            <span class="d-flex justify-content-center fw-bold">
                                Empty
                            </span>
                        @endif

                        @if ($subjects->isEmpty() && $notes->isEmpty() && $quizzes->isEmpty() && empty($this->search))
                            <span class="d-flex justify-content-center fw-bold">
                                Search Subject, Notes, Quizzes or Tags
                            </span>
                        @else
                            <div>
                                @if (!$subjects->isEmpty())
                                <div class="hrdivider">
                                    <hr class="text-primary">
                                    <span>
                                        <div class="d-flex align-items-center bg-semi-dark text-primary">
                                            Subjects&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </span>
                                </div>
                            
                                    <div class="row g-2">
                                    @foreach ($subjects as $subject)
                                        <div class="col-3">
                                            <div class="p-0 m-0 card note-card rounded-3 border border-1 border-primary" style="--bs-border-opacity: .2;">
                                                <div class="card-header border-bottom border-primary border-2 d-flex justify-content-between">
                                                    <div>
                                                        <p class="p-0 m-0 fw-bold" id="title">{{ $subject->subject_name }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="p-0 m-0" id="title">
                                                            @if(Auth::user()->user_id ==  $subject->user_id)
                                                            <i class="bi bi-person-check-fill text-primary"></i> {{$subject->username}}
                                                            @else
                                                            <i class="bi bi-person-fill"></i> {{$subject->username}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                    
                                                <div class="card-body">
                                                   
                                                </div>
                    
                                                <a href="/subjects/{{$subject->subject_id}}" target="_blank" class="stretched-link"></a>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                @endif
                            </div>

                            <div>
                                @if (!$notes->isEmpty())
                                <div class="hrdivider">
                                    <hr class="text-warning">
                                    <span>
                                        <div class="d-flex align-items-center bg-semi-dark text-warning">
                                            Notes&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </span>
                                </div>

                                    <div class="row mb-4 g-2">
                                        @foreach ($notes as $note)
                                        <div class="col-3">
                                            <div class="p-0 m-0 card note-card rounded-3 border border-1 border-warning" style="--bs-border-opacity: .2;">
                                                <div class="card-header border-bottom border-warning border-2 d-flex justify-content-between">
                                                    <div>
                                                        <p class="p-0 m-0 fw-bold" id="title">{{ $note->note_title }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="p-0 m-0" id="title">
                                                            @if(Auth::user()->user_id ==  $note->user_id)
                                                            <i class="bi bi-person-check-fill text-warning"></i> {{$note->username}}
                                                            @else
                                                            <i class="bi bi-person-fill"></i> {{$note->username}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                    
                                                <div class="card-body">
                                                   
                                                </div>
                    
                                                <a href="/subjects/{{$note->subject_id}}/{{$note->note_id}}" target="_blank"  class="stretched-link"></a>
                                            </div>
                                        </div>
                                        @endforeach
                                        </div>
                                @endif
                            </div>

                            <div>
                                @if (!$quizzes->isEmpty())
                                <div class="hrdivider">
                                    <hr class="text-info">
                                    <span>
                                        <div class="d-flex align-items-center bg-semi-dark text-info">
                                            Quizzes&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </span>
                                </div>
                            
                                    <div class="row mb-4 g-2">
                                        @foreach ($quizzes as $quiz)
                                        <div class="col-3">
                                            <div class="p-0 m-0 card note-card rounded-3 border border-1 border-info" style="--bs-border-opacity: .2;">
                                                <div class="card-header border-bottom border-info border-2 d-flex justify-content-between">
                                                    <div>
                                                        <p class="p-0 m-0 fw-bold" id="title">{{ $quiz->quiz_title }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="p-0 m-0" id="title">
                                                            @if(Auth::user()->user_id ==  $quiz->user_id)
                                                            <i class="bi bi-person-check-fill text-info"></i> {{$quiz->username}}
                                                            @else
                                                            <i class="bi bi-person-fill"></i> {{$quiz->username}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                    
                                                <div class="card-body">
                                                   
                                                </div>
                    
                                                <a href="/quizzes/{{$quiz->quiz_id}}" target="_blank"  class="stretched-link"></a>
                                            </div>
                                        </div>
                                        @endforeach
                                        </div>
                                @endif
                            </div>

                        @endif
                    </div>
                </div>


                <div class="hrdivider">
                    <hr class="text-primary">
                    <span>
                        <div class="d-flex align-items-center bg-light text-primary fs-4">
                            Quizzes&nbsp;&nbsp;&nbsp;
                        </div>
                    </span>
                </div>

                <div class="row">

                    <div class="col-md-12 col-lg-6 rounded-3">


                        <div class="justify-content-center align-items-center d-flex rounded-3 mb-3"
                            style="background-size: cover; height: 100px; background-image: url({{ asset('img/logos/panugame_banner1.png') }})">
                            <span class="fs-2 fw-bold text-light">
                                <i class="bi bi-question-square"></i>

                                Quiz Top Likes of the
                                @if ($weekly)
                                    Week!
                                @elseif ($monthly)
                                    Month!
                                @elseif ($yearly)
                                    Year!
                                @else
                                    Unknown!
                                @endif

                            </span>
                        </div>



                        @if (!$isquizlikeempty)
                            <div class="col-12 my-2">
                                <div class="bg-light rounded">
                                    <div class="bg-semi-dark p-2 rounded">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover fs-4">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">Rank</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col"><i
                                                                class="bi bi-heart-fill text-primary"></i>
                                                            Likes</th>
                                                        <th scope="col"><i
                                                                class="bi bi-person-fill text-primary"></i>
                                                            User</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($quiz_toplikes as $topl)
                                                        <tr class="text-center"
                                                            wire:click="visit({{ $topl->quiz_id }})"
                                                            style="cursor: pointer;">
                                                            <td>
                                                                @if ($count == 1)
                                                                    <span
                                                                        class="badge text-bg-primary">{{ $count }}</span>
                                                                @elseif($count == 2)
                                                                    <span
                                                                        class="badge text-bg-primary bg-opacity-75">{{ $count }}</span>
                                                                @elseif($count == 3)
                                                                    <span
                                                                        class="badge text-bg-primary bg-opacity-50">{{ $count }}</span>
                                                                @else
                                                                    <span
                                                                        class="badge text-bg-primary bg-opacity-25">{{ $count }}</span>
                                                                @endif
                                                            </td>

                                                            <td>{{ $topl->quiz_title }}</td>
                                                            <td>{{ $topl->like_count }}</td>
                                                            <td>
                                                                @if (Auth::user()->user_id == $topl->user_info[0]['user_id'])
                                                                    <i
                                                                        class="bi bi-person-check-fill text-primary"></i>
                                                                    {{ $topl->user_info[0]['username'] }}
                                                                @else
                                                                    {{ $topl->user_info[0]['username'] }}
                                                                @endif
                                                            </td>
                                                        </tr>

                                                        @php
                                                            $count++;
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div
                                class="fw-bold mb-3 p-3 bg-semi-dark rounded-3 d-flex justify-content-center align-items-center">
                                <i class="bi bi-bar-chart-line"></i>&nbsp;&nbsp; No Data
                            </div>
                        @endif



                    </div>

                    <div class="col-md-12 col-lg-6 rounded-3">

                        <div class="justify-content-center align-items-center d-flex rounded-3 mb-3"
                            style="background-size: cover; height: 100px; background-image: url({{ asset('img/logos/panugame_banner2.png') }})">
                            <span class="fs-2 fw-bold text-light">
                                <i class="bi bi-bar-chart-line"></i>

                                Quiz Top Visits of the
                                @if ($weekly)
                                    Week!
                                @elseif ($monthly)
                                    Month!
                                @elseif ($yearly)
                                    Year!
                                @else
                                    Unknown!
                                @endif

                            </span>
                        </div>

                        @if (!$isquizvisitempty)

                            <div class="col-12 my-2">
                                <div class="bg-light rounded">
                                    <div class="bg-semi-dark p-2 rounded">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover fs-4">
                                                <thead>
                                                    <tr class="text-center">
                                                        <th scope="col">Rank</th>
                                                        <th scope="col">Name</th>
                                                        <th scope="col"><i
                                                                class="bi bi-bar-chart-line-fill text-primary"></i>
                                                            Visits
                                                        </th>
                                                        <th scope="col"><i
                                                                class="bi bi-person-fill text-primary"></i>
                                                            User</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @php
                                                        $count = 1;
                                                    @endphp
                                                    @foreach ($quiz_topvisits as $topv)
                                                        <tr class="text-center"
                                                            wire:click="visit({{ $topv->quiz_id }})"
                                                            style="cursor: pointer;">
                                                            <td>
                                                                @if ($count == 1)
                                                                    <span
                                                                        class="badge text-bg-primary">{{ $count }}</span>
                                                                @elseif($count == 2)
                                                                    <span
                                                                        class="badge text-bg-primary bg-opacity-75">{{ $count }}</span>
                                                                @elseif($count == 3)
                                                                    <span
                                                                        class="badge text-bg-primary bg-opacity-50">{{ $count }}</span>
                                                                @else
                                                                    <span
                                                                        class="badge text-bg-primary bg-opacity-25">{{ $count }}</span>
                                                                @endif

                                                            </td>
                                                            <td>{{ $topv->quiz_title }}</td>
                                                            <td>{{ $topv->visit_count }}</td>
                                                            <td>
                                                                @if (Auth::user()->user_id == $topv->user_info[0]['user_id'])
                                                                    <i
                                                                        class="bi bi-person-check-fill text-primary"></i>
                                                                    {{ $topv->user_info[0]['username'] }}
                                                                @else
                                                                    {{ $topv->user_info[0]['username'] }}
                                                                @endif

                                                            </td>
                                                        </tr>

                                                        @php
                                                            $count++;
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div
                                class="fw-bold mb-3 p-3 bg-semi-dark rounded-3 d-flex justify-content-center align-items-center">
                                <i class="bi bi-bar-chart-line"></i>&nbsp;&nbsp; No Data
                            </div>
                        @endif



                    </div>

                </div>



            </div>

        </div>


</div>
</main>

</div>

<div>
    <main class="">
        <div class="">
            <div class="sticky-top bg-white p-0 m-0">
                <div class="sizebox"></div>

                <div class="p-3">

                    <div class="hrdivider">
                        <hr class="text-primary">
                        <span>
                            <div class="d-flex align-items-center bg-white text-primary fs-4">
                                Personal&nbsp;&nbsp;&nbsp;
                            </div>
                        </span>
                    </div>

                    <div class="p-3 bg-semi-dark rounded-3 mb-3">

                        <div class="row">

                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <div class="rounded-3 text-center">
                                    <h1 class="fw-bold text-primary m-0">
                                        {{round(($user_screentime->screentime_main+$user_screentime->screentime_take+$user_screentime->screentime_game) / 3600, 2)}} Hours</h1>
                                        
                                    <span class="fw-bold text-primary">Total of screentime on Panunote</span> 
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="rounded-3">
                                    <ol class="list-group">

                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Editing & Browsing</span>
                                            <span class="badge text-bg-primary">{{ round($user_screentime->screentime_main / 60, 2) }}
                                                Min</span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Taking Quiz</span>
                                            <span class="badge text-bg-primary">{{ round($user_screentime->screentime_take / 60, 2) }}
                                                Min</span>
                                        </li>

                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>Panugame</span>
                                            <span class="badge text-bg-primary">{{ round($user_screentime->screentime_game / 60, 2) }}
                                                Min</span>
                                        </li>

                                    </ol>
                                </div>
                            </div>

                         



                        </div>



                    </div>

                    <div class="p-3 bg-semi-dark rounded-3 mb-3">

                        <div class="d-flex justify-content-between align-items-center" x-data="{ alltime: @entangle('alltime') }">

                            <div class="form-check form-switch">
                                <input @click="alltime = !alltime" class="form-check-input" type="checkbox"
                                    role="switch" id="flexSwitchCheckChecked" checked>
                                <label class="form-check-label" for="flexSwitchCheckChecked">All Time</label>
                            </div>

                            <div>
                                <div class="d-flex align-items-center">
                                    <span class="mx-1 fw-bold text-primary">Start:</span>
                                    <input wire:model="start_date" type="date" class="form-control" x-bind:disabled="alltime">
                                    <span class="mx-2"></span>
                                    <span class="mx-1 fw-bold text-primary">End:</span>
                                    <input wire:model="end_date" type="date" class="form-control" x-bind:disabled="alltime">
                                    <span class="mx-2"></span>
                                    <button wire:click='find' class="btn btn-primary px-2"
                                        x-bind:disabled="alltime"><i class="bi bi-search"></i></button>
                                </div>
                            </div>

                        </div>


                    </div>


                    <div class="p-3 bg-semi-dark rounded-3 mb-3">

                        <div class="row">

                            <div class="col-6">
                                <div class="rounded-3 mb-3">
                                    <span class="badge text-bg-primary mb-2">Most Visited Subject:</span>
                                    <ol class="list-group">
                                        @if (empty($psubject_visits))
                                            <li class="list-group-item d-flex justify-content-center bg-semi-dark">
                                                <span>No Data</span>
                                            </li>
                                        @endif

                                        @if (!is_null($psubject_visits))
                                            @foreach ($psubject_visits as $sub)
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>{{ $sub['subject_name'] }}</span>
                                                    <span class="badge text-bg-primary">{{ $sub['subject_count'] }}
                                                        Visits</span>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item d-flex justify-content-center bg-semi-dark">
                                                <span>No Data</span>
                                            </li>
                                        @endif

                                    </ol>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="rounded-3 mb-3">
                                    <span class="badge text-bg-primary mb-2">Most Visited Notes:</span>
                                    <ol class="list-group">
                                        @if (empty($pnote_visits))
                                            <li class="list-group-item d-flex justify-content-center bg-semi-dark">
                                                <span>No Data</span>
                                            </li>
                                        @endif

                                        @if (!is_null($pnote_visits))
                                            @foreach ($pnote_visits as $note)
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>{{ $note['note_title'] }}</span>
                                                    <span class="badge text-bg-primary">{{ $note['note_count'] }}
                                                        Visits</span>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item d-flex justify-content-center bg-semi-dark">
                                                <span>No Data</span>
                                            </li>
                                        @endif

                                    </ol>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="rounded-3 mb-3">
                                    <span class="badge text-bg-primary mb-2">Most Visited Quiz:</span>
                                    <ol class="list-group">
                                        @if (empty($pquiz_visits))
                                            <li class="list-group-item d-flex justify-content-center bg-semi-dark">
                                                <span>No Data</span>
                                            </li>
                                        @endif

                                        @if (!is_null($pquiz_visits))
                                            @foreach ($pquiz_visits as $quiz)
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>{{ $quiz['quiz_title'] }}</span>
                                                    <span class="badge text-bg-primary">{{ $quiz['quiz_count'] }}
                                                        Visits</span>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item d-flex justify-content-center bg-semi-dark">
                                                <span>No Data</span>
                                            </li>
                                        @endif
                                    </ol>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="rounded-3 mb-3">
                                    <span class="badge text-bg-primary mb-2">Quiz Takes - Average:</span>
                                    <ol class="list-group">
                                        @if (empty($pquiz_takes))
                                            <li class="list-group-item d-flex justify-content-center bg-semi-dark">
                                                <span>No Data</span>
                                            </li>
                                        @endif

                                        @if (!is_null($pquiz_takes))
                                            @foreach ($pquiz_takes as $take)
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>{{ $take['quiz_title'] }}</span>
                                                    <span
                                                        class="badge text-bg-primary">{{ round($take['quiz_average']) }}
                                                        %</span>
                                                </li>
                                            @endforeach
                                        @else
                                            <li class="list-group-item d-flex justify-content-center bg-semi-dark">
                                                <span></span>
                                            </li>
                                        @endif
                                    </ol>
                                </div>
                            </div>


                        </div>



                    </div>

             

                    {{-- subjects --}}
                    <div class="p-3 bg-semi-dark rounded-3">

                        <div class="rounded-3 mb-3"
                            style="background-size: cover; height: 100px; background-image: url({{ asset('img/logos/panugame_banner1.png') }})">
                        </div>

                        <div class="row">



                            <div class="col-6">
                                <div class="hrdivider">
                                    <hr class="text-primary">
                                    <span>
                                        <div class="d-flex align-items-center bg-semi-dark text-primary fs-4">
                                            Top Subject - Likes&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </span>
                                </div>

                                <div class="mb-3" wire:ignore>
                                    <div class="bg-light rounded-3 p-2">
                                        <canvas id="subject_chart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="hrdivider">
                                    <hr class="text-primary">
                                    <span>
                                        <div class="d-flex align-items-center bg-semi-dark text-primary fs-4">
                                            Top Subjects - Visits&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </span>
                                </div>


                                <div class="mb-3" wire:ignore>
                                    <div class="bg-light rounded-3 p-2">
                                        <canvas id="subject_chart_visits"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- <div class="text-end">
                            <a class="fw-bold" href="activitiesandprograms">
                                <div>More Info <span><i class="bi bi-arrow-right-circle-fill"></i></span></div>
                            </a>
                        </div> --}}
                        
                        {{-- <div class="bg-light rounded-3 p-2">

                            <div class="">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover text-center">


                                        <thead>
                                            <tr>
                                                <th scope="col">Rank</th>
                                                <th scope="col">Subject ID</th>
                                                <th scope="col">Subject Name</th>
                                                <th scope="col">Subject Likes</th>
                                                <th scope="col">Subject Visits</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @php
                                                $count = 1;
                                            @endphp
                                            @foreach ($subjects as $subject)
                                                <tr>
                                                    <td scope="col">
                                                        @if ($count == 1)
                                                            <span class="badge fs-4"
                                                                style="background-color: #C9B037">{{ $count }}</span>
                                                        @elseif ($count == 2)
                                                            <span class="badge fs-4"
                                                                style="background-color: #D7D7D7">{{ $count }}</span>
                                                        @elseif ($count == 3)
                                                            <span class="badge fs-4"
                                                                style="background-color: #6A3805">{{ $count }}</span>
                                                        @else
                                                            <span class="badge fs-4"
                                                                style="background-color: #eaeaea">{{ $count }}</span>
                                                        @endif
                                                    </td>
                                                    <td scope="col">{{ $subject->subject_id }}</td>
                                                    <td scope="col">{{ $subject->subject_name }}</td>
                                                    <td scope="col">{{ $subject->subject_likes }}</td>
                                                    <td scope="col">{{ $subject->subject_visits }}</td>
                                                </tr>

                                                @php
                                                    $count++;
                                                @endphp
                                            @endforeach



                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <div class="my-3"></div>

                    {{-- notes --}}
                    <div class="p-3 bg-semi-dark rounded-3">
                        <div class="rounded-3 mb-3"
                            style="background-size: cover; height: 100px; background-image: url({{ asset('img/logos/panugame_banner2.png') }})">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="hrdivider">
                                    <hr class="text-primary">
                                    <span>
                                        <div class="d-flex align-items-center bg-semi-dark text-primary fs-4">
                                            Top Notes - Likes&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </span>
                                </div>

                                <div class="mb-3" wire:ignore>
                                    <div class="bg-light rounded-3 p-2">
                                        <canvas id="note_chart"></canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="hrdivider">
                                    <hr class="text-primary">
                                    <span>
                                        <div class="d-flex align-items-center bg-semi-dark text-primary fs-4">
                                            Top Notes - Visits&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </span>
                                </div>

                                <div class="mb-3" wire:ignore>
                                    <div class="bg-light rounded-3 p-2">
                                        <canvas id="note_chart_visits"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="text-end">
                            <a class="fw-bold" href="activitiesandprograms">
                                <div>More Info <span><i class="bi bi-arrow-right-circle-fill"></i></span></div>
                            </a>
                        </div> --}}

                        {{-- <div class="bg-light rounded-3 p-2">

                            <div class="">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover text-center">


                                        <thead>
                                            <tr>
                                                <th scope="col">Rank</th>
                                                <th scope="col">Subject ID</th>
                                                <th scope="col">Subject Name</th>
                                                <th scope="col">Subject Likes</th>
                                                <th scope="col">Subject Visits</th>
                                            </tr>
                                        </thead>

                                        <body>
                                            @php
                                                $count = 1;
                                            @endphp
                                            @foreach ($notes as $note)
                                                <tr>
                                                    <td scope="col">
                                                        @if ($count == 1)
                                                            <span class="badge fs-4"
                                                                style="background-color: #C9B037">{{ $count }}</span>
                                                        @elseif ($count == 2)
                                                            <span class="badge fs-4"
                                                                style="background-color: #D7D7D7">{{ $count }}</span>
                                                        @elseif ($count == 3)
                                                            <span class="badge fs-4"
                                                                style="background-color: #6A3805">{{ $count }}</span>
                                                        @else
                                                            <span class="badge fs-4"
                                                                style="background-color: #eaeaea">{{ $count }}</span>
                                                        @endif
                                                    </td>
                                                    <td scope="col">{{ $note->note_id }}</td>
                                                    <td scope="col">{{ $note->note_title }}</td>
                                                    <td scope="col">{{ $note->note_likes }}</td>
                                                    <td scope="col">{{ $note->note_visits }}</td>
                                                </tr>

                                                @php
                                                    $count++;
                                                @endphp
                                            @endforeach
                                        </body>

                                    </table>
                                </div>
                            </div>


                        </div> --}}
                    </div>

                    <div class="my-3"></div>

                    {{-- quizzes --}}
                    <div class="p-3 bg-semi-dark rounded-3">
                        <div class="rounded-3 mb-3"
                            style="background-size: cover; height: 100px; background-image: url({{ asset('img/logos/panugame_banner3.png') }})">
                        </div>
                        <div class="row">

                            <div class="col-6">
                                <div class="hrdivider">
                                    <hr class="text-primary">
                                    <span>
                                        <div class="d-flex align-items-center bg-semi-dark text-primary fs-4">
                                            Top Quizzes - Likes&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </span>
                                </div>


                                <div class="mb-3" wire:ignore>
                                    <div class="bg-light rounded-3 p-2">
                                        <canvas id="quiz_chart"></canvas>
                                    </div>
                                </div>

                            </div>

                            <div class="col-6">
                                <div class="hrdivider">
                                    <hr class="text-primary">
                                    <span>
                                        <div class="d-flex align-items-center bg-semi-dark text-primary fs-4">
                                            Top Quizzes - Visits&nbsp;&nbsp;&nbsp;
                                        </div>
                                    </span>
                                </div>

                                <div class="mb-3" wire:ignore>
                                    <div class="bg-light rounded-3 p-2">
                                        <canvas id="quiz_chart_visits"></canvas>
                                    </div>
                                </div>
                            </div>


                        </div>



                        {{-- <div class="text-end">
                            <a class="fw-bold" href="activitiesandprograms">
                                <div>More Info <span><i class="bi bi-arrow-right-circle-fill"></i></span></div>
                            </a>
                        </div> --}}

                        {{-- <div class="bg-light rounded-3 p-2">

                            <div class="">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover text-center">


                                        <thead>
                                            <tr>
                                                <th scope="col">Rank</th>
                                                <th scope="col">Subject ID</th>
                                                <th scope="col">Subject Name</th>
                                                <th scope="col">Subject Likes</th>
                                                <th scope="col">Subject Visits</th>
                                            </tr>
                                        </thead>

                                        <body>
                                            @php
                                                $count = 1;
                                            @endphp
                                            @foreach ($quizzes as $quiz)
                                                <tr>
                                                    <td scope="col">
                                                        @if ($count == 1)
                                                            <span class="badge fs-4"
                                                                style="background-color: #C9B037">{{ $count }}</span>
                                                        @elseif ($count == 2)
                                                            <span class="badge fs-4"
                                                                style="background-color: #D7D7D7">{{ $count }}</span>
                                                        @elseif ($count == 3)
                                                            <span class="badge fs-4"
                                                                style="background-color: #6A3805">{{ $count }}</span>
                                                        @else
                                                            <span class="badge fs-4"
                                                                style="background-color: #eaeaea">{{ $count }}</span>
                                                        @endif
                                                    </td>
                                                    <td scope="col">{{ $quiz->quiz_id }}</td>
                                                    <td scope="col">{{ $quiz->quiz_title }}</td>
                                                    <td scope="col">{{ $quiz->quiz_likes }}</td>
                                                    <td scope="col">{{ $quiz->quiz_visits }}</td>
                                                </tr>

                                                @php
                                                    $count++;
                                                @endphp
                                            @endforeach
                                        </body>

                                    </table>
                                </div>
                            </div>

                        </div> --}}

                    </div>






                    <script>
                        const subject_data = {
                            datasets: @json($subject_like_datasets)
                        };

                        const subject_config = {
                            type: 'bar',
                            data: subject_data,
                            options: {
                                plugins: {
                                    legend: {
                                        display: false, // by default it's top
                                    },
                                },
                                ticks: {
                                    precision: 0
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        };

                        const subject_chart = new Chart(
                            document.getElementById('subject_chart'),
                            subject_config
                        );

                        document.addEventListener('livewire:load', function() {
                            Livewire.on('update_subject_likes', datasets => {
                                subject_data.datasets = datasets['datasets'];
                                subject_chart.update();
                            });
                        })
                    </script>

                    <script>
                        const subject_data_visits = {
                            datasets: @json($subject_visits_datasets)
                        };

                        const subject_config_visits = {
                            type: 'bar',
                            data: subject_data_visits,
                            options: {
                                plugins: {
                                    legend: {
                                        display: false, // by default it's top
                                    },
                                },
                                ticks: {
                                    precision: 0
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        };

                        const subject_chart_visits = new Chart(
                            document.getElementById('subject_chart_visits'),
                            subject_config_visits
                        );

                        document.addEventListener('livewire:load', function() {
                            Livewire.on('update_subject_visits', datasets => {
                                subject_data_visits.datasets = datasets['datasets'];
                                subject_chart_visits.update();
                            });
                        })
                    </script>

                    <script>
                        const note_data = {
                            datasets: @json($note_like_datasets)
                        };

                        const note_config = {
                            type: 'bar',
                            data: note_data,
                            options: {
                                plugins: {
                                    legend: {
                                        display: false, // by default it's top
                                    },
                                },
                                ticks: {
                                    precision: 0
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        };

                        const note_chart = new Chart(
                            document.getElementById('note_chart'),
                            note_config
                        );

                        document.addEventListener('livewire:load', function() {
                            Livewire.on('update_note_likes', datasets => {
                                note_data.datasets = datasets['datasets'];
                                note_chart.update();
                            });
                        })
                    </script>

                    <script>
                        const note_data_visits = {
                            datasets: @json($note_visits_datasets)
                        };

                        const note_config_visits = {
                            type: 'bar',
                            data: note_data_visits,
                            options: {
                                plugins: {
                                    legend: {
                                        display: false, // by default it's top
                                    },
                                },
                                ticks: {
                                    precision: 0
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        };

                        const note_chart_visits = new Chart(
                            document.getElementById('note_chart_visits'),
                            note_config_visits
                        );

                        document.addEventListener('livewire:load', function() {
                            Livewire.on('update_note_visits', datasets => {
                                note_data_visits.datasets = datasets['datasets']
                                note_chart_visits.update();
                            });
                        })
                    </script>

                    <script>
                        const quiz_data = {
                            datasets: @json($quiz_like_datasets)
                        };

                        const quiz_config = {
                            type: 'bar',
                            data: quiz_data,
                            options: {
                                plugins: {
                                    legend: {
                                        display: false, // by default it's top
                                    },
                                },
                                ticks: {
                                    precision: 0
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        };

                        const quiz_chart = new Chart(
                            document.getElementById('quiz_chart'),
                            quiz_config
                        );

                        document.addEventListener('livewire:load', function() {
                            Livewire.on('update_quiz_likes', datasets => {
                                quiz_data.datasets = datasets['datasets']
                                quiz_chart.update();
                            });
                        })
                    </script>

                    <script>
                        const quiz_data_visits = {
                            datasets: @json($quiz_visits_datasets)
                        };

                        const quiz_config_visits = {
                            type: 'bar',
                            data: quiz_data_visits,
                            options: {
                                plugins: {
                                    legend: {
                                        display: false,
                                    },
                                },
                                ticks: {
                                    precision: 0
                                },
                                responsive: true,
                                maintainAspectRatio: false
                            }
                        };

                        const quiz_chart_visits = new Chart(
                            document.getElementById('quiz_chart_visits'),
                            quiz_config_visits
                        );

                        document.addEventListener('livewire:load', function() {
                            Livewire.on('update_quiz_visits', datasets => {
                                quiz_data_visits.datasets = datasets['datasets']
                                quiz_chart_visits.update();
                            });
                        })
                    </script>

                </div>
            </div>

        </div>
</div>
</main>
</div>

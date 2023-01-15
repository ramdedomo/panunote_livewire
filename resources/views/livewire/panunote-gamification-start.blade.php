<div>

    {{-- <div class="bg-danger">
        <div id="jstime"></div>
        <div id="phptime"></div>
        <div id="difference"></div>
    </div>

                    {{ count($rightanswer) }}
                    your answer is <strong>@json($useranswer)</strong> and the right answer is
                    <strong>@json($rightanswer)</strong>.

                    <h1>{{ $current_count }}</h1> --}}

    {{-- <div class="rounded-3 bg-info text-light position-absolute top-50 start-50 translate-middle p-5 fs-1 shadow" id="pre_timer">
        
    </div> --}}

    <div wire:ignore.self class="modal fade" id="leaderboard" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Leaderboards</h5>
                    <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </div>
                <div class="modal-body">

                    <div class="bg-semi-dark p-2 rounded">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr class="">
                                    <th scope="col">Rank</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Score</th>
                                </tr>
                            </thead>

                            <tbody>

                                @php
                                    $count = 1;
                                @endphp
                                @foreach ($playerdetails as $players)
                                    @if($players['role'] == 0)
                                        <tr>
                                            <th scope="row">
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
                                            </th>


                                            <td>
                                                @if ($players['user_id'] == Auth::user()->user_id)
                                                    <span class="fw-bold">(You)</span>
                                                @endif {{ $players['username'] }}
                                            </td>

                                            <td>{{ $players['score'] }}</td>

                                        </tr>

                                        @php
                                            $count++;
                                        @endphp
                                    @endif
                                @endforeach


                            </tbody>


                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Done</button>
                </div>
            </div>
        </div>
    </div>



    <div class="p-3 p-md-5 p-lg-5">

        {{-- @json($rightanswer);
        
        @if (!is_null($useranswer))
            @json($useranswer);
        @endif

        @if (!is_null($user_answer))
            @json($user_answer);
        @endif

        <div class="text-light">
            @json($current_start);
            @json($current_end);
        </div> --}}


        <div class="row">

            <div class="col-lg-4 col-md-12">
                <table class="table bg-light rounded-3">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Score</th>
                            <th scope="col">Username</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @php
                            $count = 1;
                        @endphp
                        @foreach ($playerdetails as $players)
                            @if ($players['role'] == 0)
                                <tr>
                                    <th scope="row">{{ $count++ }}</th>
                                    <td>{{ $players['score'] }}</td>
                                    <td>
                                        @if ($players['user_id'] == Auth::user()->user_id)
                                            <span class="fw-bold">(You)</span>
                                        @endif {{ $players['username'] }}
                                    </td>
                                    <td>
                                        @if ($players['user_status'] == 1 && $players['refreshToken'] == 1)
                                            <span class="badge text-bg-success text-light">Done</span>
                                        @elseif($players['user_status'] == 0 && $players['refreshToken'] == 1)
                                            <span class="badge text-bg-info text-light">Answering</span>
                                        @elseif($players['refreshToken'] > 1 && $players['user_status'] == 2)
                                            <span class="badge text-bg-danger text-light">Leave or No Player Left</span>
                                        @else
                                            <span class="badge text-bg-success text-light">Ended</span>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                        @if ($count == 1 && $yourrole == 1)
                            <tr>
                                <td colspan="4" class="text-center">No Player Left :(, You may leave the game</td>
                            </tr>
                        @elseif($count == 1 && $yourrole == 0)
                            <tr>
                                <td colspan="4" class="text-center">You left the game :(</td>
                            </tr>
                        @endif

                    </tbody>

                </table>
                
                <div class="p-2 bg-dark bg-opacity-25 rounded-3 text-white mb-2">
                    <i class="bi bi-info-circle-fill"></i> &nbsp; <strong> Score </strong> will add up if your answer is Correct.
                </div>

                <div class="p-2 bg-dark bg-opacity-25 rounded-3 text-white mb-2">
                    <i class="bi bi-info-circle-fill"></i> &nbsp; <strong>Navigating Back</strong> or <strong>Page Refresh</strong> will leave you in this Game.
                </div>

                @if ($yourrole == 1)
                    <div class="bg-light p-2 rounded-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <span>You're the admin in this Room</span>

                            @foreach ($playerdetails as $players)
                                @if ($players['user_id'] == Auth::user()->user_id)
                                    @if ($players['user_status'] == 1 && $players['refreshToken'] == 1)
                                        <span class="badge text-bg-success text-light">Done</span>
                                    @elseif($players['user_status'] == 0 && $players['refreshToken'] == 1)
                                        <span class="badge text-bg-info text-light">Answering</span>
                                    @elseif($players['refreshToken'] > 0 && $players['user_status'] == 2)
                                        <span class="badge text-bg-danger text-light">Leave</span>
                                    @else
                                        <span class="badge text-bg-success text-light">Ended</span>
                                    @endif
                                @endif
                            @endforeach

                        </div>
                    </div>
                @endif



                <div class="bg-light p-2 rounded-3 bg-opacity-25 d-flex justify-content-between align-items-center">
                    @if ($yourrole == 1)

                        @if ($next && !$finished)
                            <button class="btn bg-info text-light" wire:click="next_question">Next</button>
                        @elseif ($next && $finished)
                            <button data-bs-toggle="modal" data-bs-target="#leaderboard" class="btn btn-success">Show
                                Results</button>
                        @else
                            <div id="pre_timer" class="badge bg-info text-light fs-3"></div>
                        @endif

                        @if ($next && $finished)
                            <a class="btn btn-info" href="{{ route('join') }}">To Lobby</a>
                        @else
                            <div>
                                <span
                                    class="badge text-bg-info fs-3">{{ $current_count + 1 }}/{{ $this->roomdetails->item_count }}</span>
                            </div>
                        @endif
                    @else
                        @if ($next && !$finished)
                            <span class="badge bg-info text-light fs-3">Wait for the Next Question</span>
                        @elseif ($next && $finished)
                            <button data-bs-toggle="modal" data-bs-target="#leaderboard" class="btn btn-success">Show
                                Results</button>
                        @else
                            <div id="pre_timer" class="badge bg-info text-light fs-3"></div>
                        @endif

                        @if ($next && $finished)
                            <a class="btn btn-info" href="{{ route('join') }}">To Lobby</a>
                        @else
                            <div>
                                <span wire:loading>
                                    <div id="spinner"
                                        class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                                        role="status" aria-hidden="true"></div>
                                </span>
                                <span
                                    class="badge text-bg-info fs-3">{{ $current_count + 1 }}/{{ $this->roomdetails->item_count }}</span>
                            </div>
                        @endif


                    @endif
                </div>


                <hr class="d-block d-lg-none text-light">


            </div>

            <div class="col-lg-8 col-md-12">

                {{-- ready loading --}}

                {{-- <div class="progress mb-2">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                        aria-label="Animated striped example" id="progress-bar-animated-pre" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div> --}}

                {{-- loading --}}

                <div class="progress mb-2" wire:ignore>
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                        aria-label="Animated striped example" id="progress-bar-animated" aria-valuenow="75"
                        aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>

                {{-- {{ 100 - (100 * Carbon\Carbon::parse($current_end)->diffInSeconds(Carbon\Carbon::now()) / $timePeritem) }} --}}

                @if ($yourrole == 0)
                    @if (!$next && !$finished)
                        <div class="">

                            <div>
                                @if (count($rightanswer) > 1)
                                    <span class="badge bg-info mb-1">Multiple Answer</span>
                                @endif

                                <div class="fw-bold text-center bg-light p-3 mb-3 rounded-3">{!! $current_question['question_text'] !!}
                                </div>

                            </div>

                            @if (!$ended)
                                <div class="d-none" id="ans_container">
                                    @if ($current_question['question_type'] == 1)

                                        @if (count($rightanswer) > 1)
                                            <div class="row g-2">
                                                @foreach ($current_answers as $ans)
                                                    <div class="col-sm-12 col-md-6 ">
                                                        <div class="bg-light rounded-3 p-3">
                                                            <input wire:model.defer="multipleanswer"
                                                                class="form-check-input" type="checkbox"
                                                                id="flexCheckChecked{{ $ans['answer_id'] }}"
                                                                value="{{ $ans['answer_text'] }}">
                                                            <label class="form-check-label"
                                                                for="flexCheckChecked{{ $ans['answer_id'] }}">
                                                                {{ $ans['answer_text'] }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <button class="btn btn-success w-100 mt-2"
                                                wire:click="user_answer('')">Submit</button>
                                        @else
                                            <div class="row g-2">
                                                @foreach ($current_answers as $ans)
                                                    <div class="col-sm-12 col-md-6 ">
                                                        <div class="bg-light rounded-3 p-2">
                                                            <button
                                                                wire:click="user_answer('{{ $ans['answer_text'] }}')"
                                                                class="text-center w-100 btn btn-success p-3">{{ $ans['answer_text'] }}</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                        @endif
                                    @else
                                        <div class="d-flex">
                                            <input wire:model.defer="user_answer" class="form-control w-100"
                                                type="text">
                                            <span class="mx-1"></span>
                                            <button class="btn btn-success"
                                                wire:click="user_answer('')">Submit</button>
                                        </div>

                                    @endif

                                </div>
                            @endif

                        </div>
                    @endif
                @else
                    @if (!$next && !$finished)
                        {{-- <div class="bg-light bg-opacity-25 vh-50 rounded p-3"> --}}
                        <div class="">
                            <div>
                                @if (count($rightanswer) > 1)
                                    <span class="badge bg-info mb-1">Multiple Answer</span>
                                @endif

                                <div class="fw-bold text-center bg-light p-3 mb-3 rounded-3">{!! $current_question['question_text'] !!}
                                </div>

                            </div>

                            @if (!$ended)
                                <div class="d-none" id="ans_container">
                                    <div
                                        class="rounded-3 d-flex justify-content-center align-items-center p-4 bg-semi-dark border border-1 border-secondary border-opacity-25">
                                        <span class="badge bg-info text-light mx-1">Answer:</span>
                                        @foreach ($rightanswer as $ans)
                                            <span class="mx-1 badge bg-success text-light">{{ $ans }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endif
                @endif

            </div>
        </div>


        @if(!$finished)
        <div class="d-flex justify-content-end mt-2">
            <button wire:click="leave" class="btn bg-danger text-light"><i class="bi bi-escape"></i> Leave</button>
        </div>
        @endif
        
    </div>



    <script>
        document.addEventListener('livewire:load', function() {
            var audio_secs = new Audio("{{ asset('sounds/panunote_seconds.mp3') }}");
            var audio_go = new Audio("{{ asset('sounds/panunote_go.mp3') }}");
            var audio_timesup = new Audio("{{ asset('sounds/panunote_timesup.mp3') }}");
            var audio_ambient = new Audio("{{ asset('sounds/panunote_ambient.mp3') }}");
            var end = moment(@this.current_end).format('YYYY-MM-DD hh:mm:ss').valueOf();
            var post_end = moment(@this.current_end).add(5, 'seconds').format('YYYY-MM-DD hh:mm:ss').valueOf();
            var pre_start = moment(@this.current_end).subtract(@this.timePeritem, 'seconds').format(
                'YYYY-MM-DD hh:mm:ss').valueOf();
            window.addEventListener('updated_question', event => {
                end = moment(@this.current_end).format('YYYY-MM-DD hh:mm:ss').valueOf();
                pre_start = moment(@this.current_end).subtract(@this.timePeritem, 'seconds').format(
                    'YYYY-MM-DD hh:mm:ss').valueOf();
                post_end = moment(@this.current_end).subtract(5, 'seconds').format('YYYY-MM-DD hh:mm:ss')
                    .valueOf();
            })

            function pre() {

                if ((moment(pre_start).diff(moment().format('YYYY-MM-DD hh:mm:ss').valueOf()) / 1000) < 0) {
                    function showTime() {
                        var a = moment().format('YYYY-MM-DD hh:mm:ss').valueOf();
                        var b = end;
                        var c = (100 * moment(b).diff(moment(a)) / 20) / 1000;
                        document.getElementById('progress-bar-animated').style.width = (c >= 0) ? c + '%' :
                            '0%';
                        if (c <= 25 && c > 0) {
                            audio_secs.play();
                        }
                        if (c == 0) {
                            audio_timesup.play();
                            audio_secs.currentTime = 0;
                            audio_ambient.pause();
                            $('#ans_container').addClass('d-none');
                            window.livewire.emit('nextquestion');
                            @this.user_answer = "";
                        }else if(c > 0 && c < 100){
                            $('#ans_container').removeClass('d-none');
                        }

                    }
                    setInterval(showTime, 1000);

                } else if ((moment(pre_start).diff(moment().format('YYYY-MM-DD hh:mm:ss').valueOf()) / 1000) == 0) {

                    audio_go.play();
                    $('#pre_timer').html('GO!');
                    $('#ans_container').removeClass('d-none');
                    $('#pre_timer').removeClass('bg-info');
                    $('#pre_timer').addClass('bg-success');
                    audio_ambient.play();

                } else {
                    audio_secs.currentTime = 0;
                    audio_secs.play();
                    $('#pre_timer').html((moment(pre_start).diff(moment().format('YYYY-MM-DD hh:mm:ss').valueOf()) /
                        1000));

                }
            }

            setInterval(pre, 1000);

        });
    </script>

    <script>
        $(document).ready(function() {

            Echo.channel('adminleaves')
                .listen('AdminLeaved', (e) => {
                    window.Livewire.emit('adminleaves', e.room_id);
                });

            Echo.channel('questionnexted')
                .listen('QuestionNext', (e) => {
                    window.Livewire.emit('questionnexted', e.room_id);
                });

                Echo.channel('playeradminized')
                .listen('PlayerAdminize', (e) => {
                    window.Livewire.emit('playeradminized', e.user_id);
            });

            Echo.channel('useranswered')
                .listen('UserAnswer', (e) => {
                    window.Livewire.emit('useranswered');
                });
        });
    </script>

    <script>
        document.addEventListener('livewire:load', function() {
            window.onbeforeunload = function() {
                window.livewire.emit('getscreentime', TimeMe.getTimeOnCurrentPageInSeconds());
            }
        })
    </script>

</div>

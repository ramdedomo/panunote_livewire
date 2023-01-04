<div class="h-100">
    <main>
        <div class="">
            <div class="p-0 m-0 vh-100 d-flex align-items-center justify-content-center">
                <div class="">
                    <img class="mb-3" style="width: 350px;" src="{{ asset('img/logos/panugame_logo.png') }}"
                        alt="">
                    <div class="bg-light rounded-3 p-2 shadow-md">
                        <div>


                            <a href="{{ route('join') }}" class="text-decoration-none text-light">
                                <div class="fs-1 p-1 rounded-3 shadow-sm text-center mb-2 join_btn">
                                    Join
                                </div>
                            </a>

                            <a href="{{ route('create') }}" class="text-decoration-none text-light">
                                <div class="fs-1 p-1 rounded-3 shadow-sm text-center create_btn">
                                    Create
                                </div>
                            </a>

                            @if($isjoined)
                            <div class="text-center mt-2 bg-semi-dark rounded-3 p-2" style="font-size: 12px">
                               <strong>Warning:</strong> You Currently Joined in a Game! Clicking<br>
                                button above will leave you on the Joined Game.
                            </div>
                        
                            @endif

                        </div>
                    </div>

                    <div class="text-center mt-3">
                        <a class="text-light" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button"
                            aria-controls="offcanvasExample" href=""><i class="bi bi-list-stars"></i> My Game
                            History</a>
                    </div>
                    

                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
                        aria-labelledby="offcanvasExampleLabel">
                        <div
                            class="offcanvas-header border-bottom border-1 border-primary d-flex justify-content-between">

                            <div class="py-1 text-primary rounded fs-3">
                                <span class="fw-bold">My Game History</span>
                            </div>

                            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>

                        </div>

                        <div class="offcanvas-body">


                            <div class="text-center mb-3">
                                <div class="bg-semi-dark rounded-3 border border-1 border-secondary border-opacity-25 p-3 h-100">
                                    <i class="bi bi-info-circle-fill"></i> &nbsp;List of Participated Game
                                </div>
                            </div>


                            @foreach ($game as $g)
                                <a href="/panugame/{{$g->game_id}}" class="text-decoration-none mb-2 p-2 quiz-picker rounded-3 d-flex justify-content-between">
                                    <div><span class="badge bg-warning text-light">{{$g->game_id}}</span>&nbsp;<strong>{{$g->game_description}}</strong></div>
                                    
                                    @if($g->role == 1)
                                    <span class="badge bg-primary text-light">Admin</span>
                                    @else
                                    <span class="badge bg-primary text-light">Score: {{$g->score}}</span>
                                    @endif
                                  
                                </a>
                            @endforeach
                    





                        </div>

                        <div class="offcanvas-footer bg-semi-dark">
                            <div class="p-3 d-flex justify-content-end">
                                <button class="btn btn-secondary" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
                            </div>
                        </div>

                    </div>


                </div>

            </div>
        </div>
    </main>

</div>

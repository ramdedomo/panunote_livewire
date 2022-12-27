<div wire:poll.5s>

    {{-- {{$yourrole}} --}}

    {{-- <div class="bg-info text-light position-absolute top-50 start-50 translate-middle p-5 fs-1 shadow" id="pre_timer">
        asdasda
    </div> --}}

    <div class="p-3 p-md-5 p-lg-5">
        <div>
            <img class="mb-3" style="width: 200px;" src="{{ asset('img/logos/panugame_logo.png') }}"
                alt="">
        </div>

        <div class="p-2 bg-dark bg-opacity-25 rounded-3 text-white">
            <i class="bi bi-info-circle-fill"></i> &nbsp; <strong>Navigating Back</strong> or <strong>Page Refresh</strong> will leave you from this lobby.
    </div>


        <div class="bg-light rounded">

        <div class="p-3 bg-semi-dark rounded-top my-2">
            

                    <div class="d-flex justify-content-between">
                        <div>
                           Lobby
                        </div>
                        <div>
                            Game ID: <strong>{{$game_id}}</strong>
                        </div>
                    </div>

                    <hr class="my-2">
                  
                    <div class="d-flex justify-content-between mb-2">
                        <h1 class="mb-0 pb-0">{{$roomdetails->game_description}}</h1>
                        <h1 class="mb-0 pb-0">

                            {{$roomdetails->player_count }} / 

                            @if($roomdetails->game_capacity == 0)
                            5 Players
                            @elseif($roomdetails->game_capacity == 1)
                            10 Players
                            @else
                            15 Players
                            @endif
                        
                        </h1>
                    </div>


                    <p class="fw-bold p-0 m-0">
                        @if($roomdetails->game_difficulty == 0)
                        <span class="badge text-bg-success text-light">Easy</span>
                        @elseif($roomdetails->game_difficulty == 1)
                        <span class="badge text-bg-primary text-light">Intermediate</span>
                        @else
                        <span class="badge text-bg-danger text-light">Hard</span>
                        @endif

                        <span class="badge text-bg-secondary text-light">{{$roomdetails->item_count}} Items</span>

                        @if($roomdetails->time == 0)
                        <span class="badge text-bg-info text-light">10 Seconds / Item</span>
                        @elseif($roomdetails->time == 1)
                        <span class="badge text-bg-info text-light">20 Seconds / Item</span>
                        @elseif($roomdetails->time == 2)
                        <span class="badge text-bg-info text-light">30 Seconds / Item</span>
                        @endif

                    </p>


        </div>

        
                {{-- admin --}}
        @if($yourrole == 1)
        <div class="p-3">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Player ID:</th>
                        <th scope="col">Player Name:</th>
                        <th scope="col">Role</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
            
                    @foreach ($players as $player)
                        <tr>
                            <td>{{$player->user_id}}</td>
                            <td>@if($player->user_id == session('USER_ID')) <span class="fw-bold">(You)</span> @endif {{$player->username}}</td>
                            <td>@if($player->user_id == session('USER_ID')) Guest @else Admin @endif</td>
                            <td>@if($player->user_id != session('USER_ID')) <button wire:click="kick({{$player->user_id}})" class="btn-danger btn">Kick</button> <button wire:click="adminize({{$player->user_id}})" class="btn-info btn">Make Admin</button> @endif</td>
                        </tr>
                    @endforeach
            
                    </tbody>
                </table>
            </div>
    
        {{-- player --}}
        @else
        <div class="p-3">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">Player ID:</th>
                        <th scope="col">Player Name:</th>
                        <th scope="col">Role</th>
                    </tr>
                    </thead>
                    <tbody>
            
                    @foreach ($players as $player)
                        <tr>
                            <td>{{$player->user_id}}</td>
                            <td>@if($player->user_id == session('USER_ID')) <span class="fw-bold">(You)</span> @endif {{$player->username}}</td>
                            <td>@if($player->user_id == session('USER_ID')) Guest @else Admin @endif</td>
                        </tr>
                    @endforeach
            
                    </tbody>
                </table>
            </div>
        @endif
    
        @if($yourrole == 1)
        <div class="p-3 d-flex justify-content-between">
            <div class="w-100 rounded bg-semi-dark d-flex align-items-center">
                <span wire:loading>
                    <div id="spinner" class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                        role="status" aria-hidden="true"></div>
                </span>
            </div>
            <div class="mx-1"></div>
            <div>
                @if($isadmin)
                    <button wire:loading.remove wire:click="start" class="btn btn-primary">Start</button> 
                @endif
            </div>
        </div>
         @endif

        </div>

        <hr class="text-light">
        <div class="mt-2">
            <button wire:click="leave" class="btn btn-link text-light"><i class="bi bi-escape"></i> Leave</button>
        </div>


    </div>



    <script>

        document.addEventListener('livewire:load', function() {
            
            Echo.channel('playerjoined')
                .listen('PlayerJoin', (e) => {
                    window.Livewire.emit('playerjoined', e.playername);
            });

            Echo.channel('playeradminized')
                .listen('PlayerAdminize', (e) => {
                    window.Livewire.emit('playeradminized', e.user_id);
            });

            Echo.channel('playerkicked')
                .listen('PlayerKick', (e) => {
                    window.Livewire.emit('playerkicked', e.user_id);
            });

            Echo.channel('roomstarted')
                .listen('RoomStart', (e) => {
                    alert('start');
                    if(@this.game_id == e.room_id){
                        window.Livewire.emit('roomstarted', e.room_id);
                    }
            });
        
        });
    </script>

    @if (session()->has('kicked'))
        <script>
        setTimeout(function() {
            window.location.href = "/panugame/join";
        }, 3000); // 3 second
        </script>
    @endif
  
</div>

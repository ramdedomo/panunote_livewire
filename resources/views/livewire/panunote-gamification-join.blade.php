<div>

    <div wire:ignore.self class="modal fade" id="private_password" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Game Password</h5>
              <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>

            <div class="modal-body">

                    <div class="row">
                        
                        <div class="col-6">
                            Game ID:
                        </div>

                        <div class="col-6">
                            Password: <span>@error('wrongpass'){{$message}}@enderror</span>
                            
                        </div>

                        <div class="col-6">
                            <input wire:model="joinprivateid" disabled class="form-control" type="text">
                        </div>

                        <div class="col-6">
                            <input placeholder="@error('joinprivatepassword') {{$message}} @else Password @enderror" wire:model="joinprivatepassword" class="form-control" type="text">
                        </div>
                    </div>
                

            </div>
            <div class="modal-footer">
                <button wire:click="joinprivate({{$joinprivateid}})" class="btn btn-primary">Join</button>
            </div>

        
          </div>
        </div>
      </div>


    <main>
        <div>
            <div class="p-3 p-md-5 p-lg-5">


                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <img class="mb-3" style="width: 200px;" src="{{ asset('img/logos/panugame_logo.png') }}" alt="">
                    </div>
    
                    <div>
                        <a href="/panugame" type="button" class="btn btn-outline-light"><i class="bi bi-arrow-left-circle"></i> Go Back</a>
                    </div>
                </div>


                <hr class="text-light my-1">

                <div>
                    {{-- @if(!$isjoined) --}}
                    <div class="row rounded">

                        <div class="col-sm-12 col-md-4 my-2">

                            <div class="bg-light rounded p-2 mb-2">
                            <a href="{{ route('create') }}" class="text-decoration-none text-light">
                                <div class="fs-1 p-1 rounded-3 shadow-sm text-center create_btn">
                                    Create Instead
                                </div>
                            </a>
                            </div>
                            
                            <div class="bg-light rounded p-2 mt-4">
                                <p class="fw-bold py-1 m-0">Join Servers:</p>
                                <hr class="my-0 mb-2">
    
                                <div class="bg-semi-dark p-2 rounded">
                                    <div>
                                        Game ID:
                                        @error('joinmanualid'){{ $message }}@enderror
                                        <input wire:model="joinmanualid" type="text" class="bg-light form-control mb-2">
                                    </div>
    
                                    <div>
                                        Password:
                                        @error('joinmanualpassword'){{ $message }}@enderror
                                        <input wire:model="joinmanualpassword" type="text" class="bg-light form-control mb-2">
                                    </div>
                                </div>
                                <hr class="my-2">
                                <div>
                                    <div class="d-none d-md-block">
                                        <button wire:click="joinmanual()" class="btn btn-primary w-100">Join <i class="bi bi-arrow-right-circle"></i></button>
                                    </div>

                                    <div class="d-block d-md-none">
                                        <button wire:click="joinmanual()" class="btn btn-primary w-100">Join <i class="bi bi-arrow-right-circle"></i></button>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-sm-12 col-md-8 my-2">
                            <div class="bg-light rounded p-2">
                                
                                <p class="fw-bold py-1 m-0">Servers:</p>
                                <hr class="my-0 mb-2">
        

                                <div class="row gx-1 mb-2 gy-1">

                                    <div class="col-md-6 col-12">
                                        <input wire:model.debounce.500ms="search" placeholder="Search GameID/Name" type="text" class="form-control">
                                    </div>


                                    <div class="col-md-6 col-12">

                                        <div class="d-flex-game">
                                       
                                            <div class="input-group first w-100" wire:ignore>
                                                <select 
                                                data-selected-text-format="static"
                                                data-style="btn-primary"
                                                class="lobbyfilter selectpicker"
                                                multiple data-width="100%"
                                                title="Status"
                                                wire:model="status" 
                                                >

                                                
                                                <optgroup label="Status">
                                                    <option value="0" data-content='<span class="badge rounded-pill text-bg-secondary text-light">Waiting</span>'>Waiting</option>
                                                    <option value="1"  data-content='<span class="badge rounded-pill text-bg-success text-light">Started</span>'>Started</option>
                                                    <option value="2"  data-content='<span class="badge rounded-pill text-bg-primary text-light">On Going</span>'>Ongoing</option>
                                                    <option value="3"  data-content='<span class="badge rounded-pill text-bg-warning text-light">Ended</span>'>Ended</option>
                                                </optgroup>
    
                                                </select>
                                            </div>



                                            <div class="input-group first w-100" wire:ignore>
                                                <select 
                                                data-selected-text-format="static"
                                                data-style="btn-primary"
                                                class="lobbyfilter selectpicker"
                                                multiple data-width="100%"
                                                title="Type"
                                                wire:model="type" 
                                                >
    
                                                    <optgroup label="Type">
                                                    <option value="1" data-content='<span class="badge text-bg-warning text-light"><i class="bi bi-lock-fill"></i> Private</span>'>Private</option>
                                                    <option value="0" data-content='<span class="badge text-bg-success text-light"><i class="bi bi-unlock-fill"></i> Public</span>'>Public</option>
                                                    </optgroup>

    
                                                </select>
                                            </div>


                                            

                                            
                                      
                                        </div>


                                    </div>

                                    {{-- @json($sample); --}}

                                </div>

        
                                <div class="bg-semi-dark p-2 rounded">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                              <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Players <span wire:click="sortId(1)" class="btn badge text-bg-info">@if($sortCount_bool) <i class="bi bi-sort-down"></i> @else <i class="bi bi-sort-down-alt"></i> @endif </span></th>
                                                <th scope="col">Items <span wire:click="sortId(2)" class="btn badge text-bg-info">@if($sortItem_bool) <i class="bi bi-sort-down"></i> @else <i class="bi bi-sort-down-alt"></i> @endif </span></th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Join</th>
                                              </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($rooms as $room)
                                              <tr>
                                                <th scope="row">{{$room->game_description}}</th>
        
                                                <td>
                                                    {{$room->player_count}}
                                                    /
                                                    @if($room->game_capacity == 0)
                                                    @php
                                                        $room->game_capacity = 10;
                                                    @endphp
                                                    {{$room->game_capacity}}
                                                    @elseif($room->game_capacity == 1)
                                                    @php
                                                        $room->game_capacity = 15;
                                                    @endphp
                                                    {{$room->game_capacity}}
                                                    @else
                                                    @php
                                                        $room->game_capacity = 30;
                                                    @endphp
                                                    {{$room->game_capacity}}
                                                    @endif
                                                </td>
        
                                                <td>{{$room->item_count}} Items</td>
        
                                                <td>
                                                    @if($room->status == 0)
                                                    <span class="badge rounded-pill text-bg-secondary text-light">Waiting</span>
                                                    @elseif($room->status == 1)
                                                    <span class="badge rounded-pill text-bg-success text-light">Started</span>
                                                    @elseif($room->status == 2)
                                                    <span class="badge rounded-pill text-bg-primary text-light">On Going</span>
                                                    @elseif($room->status == 3)
                                                    <span class="badge rounded-pill text-bg-warning text-light">Ended</span>
                                                    @endif
                                                </td>
        
                                                <td>
                                                    @if($room->is_private == 1)
                                                    <span class="badge text-bg-warning text-light"><i class="bi bi-lock-fill"></i> Private</span>
                                                    @else
                                                    <span class="badge text-bg-success text-light"><i class="bi bi-unlock-fill"></i> Public</span>
                                                    @endif
                                                </td>
        
                                                <td>
                                                    {{-- if game is private enter a password --}}
                                                    @if($room->is_private == 1)
                                                    {{-- if player count us not equal to capacity players can join --}}
                                                   
                                                        @if($room->player_count != $room->game_capacity)
                                                            @if($room->status >= 1 && $room->status <= 3)
                                                            <button disabled class="badge btn btn-secondary px-3">Join <i class="bi bi-arrow-right-circle"></i></button>
                                                            @else
                                                            <a wire:loading.remove wire:click="joinpriv({{$room->game_id}})" data-bs-toggle="modal" data-bs-target="#private_password" class="px-3 badge btn btn-primary">Join <i class="bi bi-arrow-right-circle"></i></a>
                                                            @endif
                                                        @else
                                                            <button disabled class="badge btn btn-secondary px-3">Join <i class="bi bi-arrow-right-circle"></i></button>
                                                        @endif
                                                    @else

                                                        @if($room->player_count != $room->game_capacity)
                                                            @if($room->status >= 1 && $room->status <= 3)
                                                            <button disabled class="badge btn btn-secondary px-3">Join <i class="bi bi-arrow-right-circle"></i></button>
                                                            @else
                                                            <a wire:loading.remove wire:click="join({{ $room->game_id }})" class="badge btn btn-primary px-3">Join <i class="bi bi-arrow-right-circle"></i></a>
                                                            @endif
                                                        @else
                                                            <button disabled class="badge btn btn-secondary px-3">Join <i class="bi bi-arrow-right-circle"></i></button>
                                                        @endif
                                                    @endif
                                                </td>
                                              </tr>
                                            @endforeach
        
                                            </tbody>
                                            

                                       
                                           
                                          </table>
                                    </div>
                                  
                                    <div class="mt-3 d-flex">
                                        {!! $links !!}
                                        <span class="mx-1"></span>
                                        <div class="bg-light w-100 rounded"></div>
                                    </div>
                                </div> 
                            
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

                <hr class="text-light my-1">
            </div>
        </div>
    </main>

    <script>
        $( document ).ready(function() {
            Echo.channel('roomcreated')
                .listen('RoomCreate', (e) => {
                    window.Livewire.emit('roomcreated');
            });      
        });
    </script>

</div>

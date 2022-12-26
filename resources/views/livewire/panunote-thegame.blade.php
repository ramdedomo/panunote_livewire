{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
</body>
</html> --}}

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


    <main class="">
        <div class="">
            <div class="bg-white p-0 m-0">
                <div class="sizebox"></div>

                @if(!$isjoined)
                <div class="row m-3">
                    <div class="col-12 bg-semi-dark p-2 rounded mb-2">
                        <p class="fw-bold py-1 m-0">Join Servers:</p>
                        <hr class="my-0 mb-2">

                        <div>
                            <div class="mb-2 d-flex justify-content-between align-items-center">
                                <div></div>
                                <div><input placeholder="search" type="text" class="form-control"></div>
                            </div>
                        </div>

                        <div class="bg-light p-2 rounded">
                            <div class="table-responsive">
                                <table class="table table-striped" wire:poll.1s="refreshrooms">
                                    <thead>
                                      <tr>
                                        <th scope="col">Game ID:</th>
                                        <th scope="col">Players</th>
                                        <th scope="col">Items</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Join</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                        
                                    @foreach($rooms as $room)
                                      <tr>
                                        <th scope="row">{{$room->game_id}}</th>

                                        <td>
                                            {{$playercount[$room->game_id]}}
                                            /
                                            @if($room->game_capacity == 0)
                                            10
                                            @elseif($room->game_capacity == 1)
                                            15
                                            @else
                                            30
                                            @endif
                                        </td>

                                        <td>{{$itemscount[$room->game_id]}} Items</td>

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
                                            <span class="badge text-bg-success text-light"><i class="bi bi-unlock"></i> Public</span>
                                            @endif
                                        </td>

                                        <td>
                                            {{-- if game is private enter a password --}}
                                            @if($room->is_private == 1)
                                            {{-- if player count us not equal to capacity players can join --}}
                                                @if($playercount[$room->game_id] != $room->game_capacity)
                                                    <a wire:click="joinpriv({{$room->game_id}})" data-bs-toggle="modal" data-bs-target="#private_password" class="btn-primary btn">Join</a>
                                                @else
                                                    <button disabled class="btn-secondary btn">Join</button>
                                                @endif
                                            @else
                                                @if($playercount[$room->game_id] != $room->game_capacity)
                                                    <a wire:click="join({{ $room->game_id }})" class="btn-primary btn">Join</a>
                                                @else
                                                    <button disabled class="btn-secondary btn">Join</button>
                                                @endif
                                            @endif
                                        </td>
                                      </tr>
                                    @endforeach

                                    </tbody>
                                  </table>

                            </div>
                        </div> 
                    </div>


                    <div class="col-12 bg-semi-dark p-2 rounded">

                        <div class="row">
                            <div class="col-sm-12 col-md-4 mb-2">
                                <p class="fw-bold py-1 m-0">Join:</p>
                                <hr class="my-0 mb-2">
                                <div class="bg-light p-2 rounded">
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

                                    <div>
                                        <div class="d-none d-md-block">
                                            <button wire:click="joinmanual()" class="btn btn-primary">Join</button>
                                        </div>

                                        <div class="d-block d-md-none">
                                            <button wire:click="joinmanual()" class="btn btn-primary w-100">Join</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-12 col-md-8 mb-2">
                                <p class="fw-bold py-1 m-0">Create:</p>
                                <hr class="my-0 mb-2">
                                <div class="bg-light rounded p-2">
                                    
                                <form wire:submit.prevent="create">
                                    <div class="row">
                                        <div class="col-6">
                                            Description:
                                            @error('createDescription'){{ $message }}@enderror
                                            <input placeholder='' wire:model="createDescription" type="text" class="bg-light form-control mb-2">
                                        </div>

                                        <div class="col-6">
                                            Public:
                                            @error('privatePass'){{ $message }}@enderror
                                            <div class="input-group mb-3">
                                                <div class="input-group-text">
                                                  <input wire:click="isPublic" wire:model="isPublic" checked class="form-check-input mt-0" type="checkbox">
                                                </div>

                                         
                                                <input @if($isReadonly) disabled @endif wire:model="privatePass" placeholder='password' type="text" class="form-control" aria-label="Text input with checkbox">
                                            </div>                                              
                                        </div>
    
                                        <div class="col-3">
                                            Quiz:
                                            <select wire:model="quizSelect" class="form-select" aria-label="Default select example">
                                                @foreach ($quiz_list as $quiz)
                                                    <option value="{{$quiz->quiz_id}}">{{ $quiz->quiz_title }}</option>
                                                @endforeach
                                              </select>
                                        </div>

                                        <div class="col-3">
                                            Capacity:
                                            <select wire:model="capaSelect" class="form-select" aria-label="Default select example">
                                                <option value="0">10 Players</option>
                                                <option value="1">15 Players</option>
                                                <option value="2">30 Players</option>
                                              </select>
                                        </div>

                                        <div class="col-3">
                                            Time per question:
                                            <select wire:model="timeSelect"  class="form-select" aria-label="Default select example">
                                                <option value="0">10 Seconds</option>
                                                <option value="1">30 Seconds</option>
                                                <option value="2">60 Seconds</option>
                                              </select>
                                        </div>

                                        <div class="col-3">
                                            Difficulty:
                                            <select wire:model="diffSelect"  class="form-select" aria-label="Default select example">
                                                <option value="0">Easy</option>
                                                <option value="1">Intermediate</option>
                                                <option value="2">Hard</option>
                                              </select>
                                        </div>
    
                                        <div class="mt-2">
                                            <div class="d-none d-md-block">
                                                <button class="btn btn-primary">Create</button>
                                            </div>

                                            <div class="d-block d-md-none">
                                                <button class="btn btn-primary w-100">Create</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
                @else
                <div class="p-5 d-flex justify-content-center align-items-center">
                    It looks like you're already in an ongoing game.
                    <div wire:click="rejoin({{$alreadyjoinedid}})" class="mx-2"><button class="btn btn-sm btn-primary">Join</button></div>
                </div>
                @endif

            </div>
        </div>
    </main>
</div>


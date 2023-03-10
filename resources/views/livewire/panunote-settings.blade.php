<div>
    <div wire:ignore.self class="modal fade" id="modify" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Modify Personal Info</h5>
                    <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </div>

                <form wire:submit.prevent="submit">

                    <div class="modal-body">


                        @if (Session::has('successinfo'))
                            <div class="p-3 mb-3 bg-primary rounded-3 bg-opacity-25 border border-primary"
                                role="alert">
                                {{ Session::get('successinfo') }}
                            </div>
                        @endif

{{-- 
                        @if (Session::has('errorinfo'))
                            <div class="p-3 mb-3 bg-secondary rounded-3 bg-opacity-25 border border-dark"
                                role="alert">
                       
                            </div>
                        @endif --}}



                        @if ($errors->any() || Session::has('errorinfo'))
                            <div class="p-3 mb-3 bg-danger rounded-3 bg-opacity-25 border border-danger"
                                role="alert">
                                {{ Session::get('errorinfo') }}
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                            </div>
                        @endif

                        <div class="row">
                            <div class="hrdivider m-0 mt-2">
                                <hr class="text-primary">
                                <span>
                                    <div class="d-flex align-items-center text-primary">
                                        <i class="bi bi-person-badge-fill"></i>&nbsp; Personal Info&nbsp;&nbsp;&nbsp;
                                    </div>
                                </span>
                            </div>


                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="" class="form-label"> Firstname</label>
                                <input wire:model.defer="user_fname" type="text" class="form-control" id=""
                                    placeholder="">
                            </div>

                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="" class="form-label"> Lastname</label>
                                <input wire:model.defer="user_lname" type="text" class="form-control" id=""
                                    placeholder="">
                            </div>

                            <div class="hrdivider m-0 mt-3">
                                <hr class="text-primary">
                                <span>
                                    <div class="d-flex align-items-center text-primary">
                                        <i class="bi bi-person-fill"></i>&nbsp; Account Info&nbsp;&nbsp;&nbsp;
                                    </div>
                                </span>
                            </div>

                            <div class="mb-3 col-sm-6 col-md-6">
                                <label for="" class="form-label"> Username</label>
                                <input wire:model.defer="username" type="text" class="form-control" id=""
                                    placeholder="">
                            </div>

                            
                            <div class="mb-3 col-sm-6 col-md-6">
                                <label for="" class="form-label">&nbsp;</label>
                                <input disabled type="text" class="form-control" id="" placeholder="">
                            </div>

                        </div>



                    </div>
                    <div class="modal-footer">
                        <button data-bs-dismiss="modal" aria-label="Close" type="button"
                            class="btn btn-secondary">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="changephoto" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Change Profile</h5>
                    <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </div>
                <div class="modal-body" x-data="{ remove: false }">


                    @if (Session::has('successphoto'))
                        <div class="p-3 mb-3 bg-primary rounded-3 bg-opacity-25 border border-primary" role="alert">
                            {{ Session::get('successphoto') }}
                        </div>
                    @endif


                    @if (Session::has('errorphoto'))
                        <div class="p-3 mb-3 bg-danger rounded-3 bg-opacity-25 border border-danger" role="alert">
                            {{ Session::get('errorphoto') }}
                        </div>
                    @endif

                    @if (!is_null($user_info->user_photo) || !empty($user_info->user_photo))
                        <div class="rounded bg-semi-dark p-2 mb-3">
                            <div class="text-center d-flex justify-content-between px-2">
                                <span>Remove Photo</span>
                                <span>
                                    <div class="form-check form-switch">
                                        <input wire:model="removephoto" @click="remove = !remove"
                                            class="form-check-input" type="checkbox" role="switch"
                                            id="flexSwitchCheckChecked">
                                    </div>
                                </span>

                            </div>
                        </div>
                    @endif

                    
                    @error('display_picture')
                        <div class="p-3 mb-3 bg-danger rounded-3 bg-opacity-25 border border-danger" role="alert">
                            {{ $message }}
                        </div>
                    @enderror


                    <form wire:submit.prevent="save">

                        <div x-transition x-show="!remove">

                            <div class="text-center bg-semi-dark p-2 rounded mb-2 w-100" wire:loading
                                wire:target="display_picture">Uploading...</div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Choose Photo</span>
                                <input wire:model="display_picture" accept="image/png, image/jpeg, image/jpg"
                                    type="file" class="form-control" placeholder="Username" aria-label="Username"
                                    aria-describedby="basic-addon1">
                         
                            </div>



                            {{-- @if ($display_picture)
                                <div class="d-flex justify-content-center p-2">
                                    <div class="d-flex align-items-center justify-content-center fw-bold text-primary">
                                        Photo Selected:
                                    </div>

                                    <span class="mx-2"></span>
                                    <img width="120px" class="rounded-3 border border-2 border-primary"
                                        src="{{ $display_picture->temporaryUrl() }}">
                                </div>
                            @endif --}}
                        </div>


                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" aria-label="Close" type="button"
                        class="btn btn-secondary">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>


            </div>
        </div>
    </div>

    <div wire:ignore.self class="modal fade" id="changepassword" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Change Password</h5>
                    <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
                </div>


                <div class="modal-body" x-data="{ remove: false }">

                    @if ($errors->any() || Session::has('error'))
                        <div class="p-3 mb-3 bg-danger rounded-3 bg-opacity-25 border border-danger" role="alert">
                            {{ Session::get('error') }}
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="p-3 mb-3 bg-primary rounded-3 bg-opacity-25 border border-primary" role="alert">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    {{-- @if (Session::has('error'))
                        <div class="p-3 mb-3 bg-secondary rounded-3 bg-opacity-25 border border-dark" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif --}}

                    <div class="row g-2">
                        <div class="col-12 mb-2">
                            <span class="input-group-text mb-2" id="basic-addon1">Old Password</span>
                            <input wire:model='oldpassword' type="password" class="form-control">
                        </div>

                        <div class="col-sm-12 col-lg-6 mb-3" x-data="{ show: false }">
                            <div class="d-flex">
                                <span class="w-100 input-group-text mb-2" id="basic-addon1">New Password</span>
                                <span class="mx-1"></span>
                                <button @click="show = ! show" class="btn btn-primary mb-2 px-2">
                                    <i :class="show ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill'">
                                    </i></button>
                            </div>

                            <input wire:model='password' :type="show ? 'text' : 'password'" class="form-control">
                        </div>

                        <div class="col-sm-12 col-lg-6 mb-3" x-data="{ show: false }">
                            <div class="d-flex">
                                <span class="w-100 input-group-text mb-2" id="basic-addon1">Confirm Password</span>
                                <span class="mx-1"></span>
                                <button @click="show = ! show" class="btn btn-primary mb-2 px-2">
                                    <i :class="show ? 'bi bi-eye-slash-fill' : 'bi bi-eye-fill'">
                                    </i></button>
                            </div>

                            <input wire:model='password_confirmation' :type="show ? 'text' : 'password'" class="form-control">
                        </div>

                    </div>



                </div>
                <div class="modal-footer">
                    <button data-bs-dismiss="modal" aria-label="Close" type="button"
                        class="btn btn-secondary">Close</button>
                    <button wire:click="password" class="btn btn-primary">Save</button>
                </div>


            </div>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="changeemail" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Change Email</h5>
                <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>



            <div class="modal-body">

                @if ($errors->any() || Session::has('error'))
                <div class="p-3 mb-3 bg-danger rounded-3 bg-opacity-25 border border-danger" role="alert">
                    <span>{{ Session::get('error') }}</span>
                    @foreach ($errors->all() as $error)
                        <span>{{ $error }}</span>
                    @endforeach
                </div>
                @endif
    
                @if (Session::has('success'))
                    <div class="p-3 mb-3 bg-primary rounded-3 bg-opacity-25 border border-primary" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
    
                {{-- @if (Session::has('error'))
                    <div class="p-3 mb-3 bg-secondary rounded-3 bg-opacity-25 border border-dark" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif --}}


            <div class="mb-3">
                <span class="input-group-text mb-2" id="basic-addon1">Email</span>
                <div class="d-flex">
                    <div class="w-100">
                        <input wire:model.defer="email" type="email" class="form-control" id=""
                        placeholder="">
                    </div>
                    <span class="mx-1"></span>
                    <div>
                        <button class="btn btn-primary d-flex" wire:click="changeemail">
                            <span class="me-1" wire:loading wire:target="changeemail">
                                <span id="spinner"
                                    class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                                    role="status" aria-hidden="true"></span>
                            </span>
                            Change
                            
                        </button>
                    </div>
                </div>

                <div class="bg-semi-dark p-3 rounded-3 my-2 text-center" style="font-size: 12px">
                    <i class="bi bi-info-circle-fill"></i> To Change Email enter your new Email Above and Click Change, <br> after sending, check your email and enter the code below and click verify.
                </div>

                <div class="bg-semi-dark p-3 rounded-3 border-4 border-bottom border-primary mt-2">
                    <div class="d-flex fw-bold"><label for="password">Enter Code Here:</label></div>

                    <div class="d-flex" x-data='{show: false}'>

                        <div class="w-100">
                            <input :type="show ? 'text' : 'password'" class="text-center form-control mb-3"
                                wire:model="verification_code">
                        </div>

                        <span class="mx-1"></span>
                        
                        <div>
                            <button @click="show = ! show" type="button" class="btn btn-primary px-2"><i
                                    :class="show ? 'bi bi-eye-fill' : 'bi bi-eye-slash-fill'"></i></button>
                        </div>

                    </div>
                </div>

                
                <button wire:click="verifycode" class="btn btn-primary w-100 text-center mt-2">
                    Verify
                </button>   
            </div>


            </div>

            <div class="modal-footer">
                <button data-bs-dismiss="modal" aria-label="Close" type="button"
                    class="btn btn-primary">Done</button>
            </div>


        </div>
    </div>
</div>

    <main class="">
        <div class="">
            <div class="bg-white p-0 m-0">
                <div class="sizebox"></div>

                <style>
                    .imgcontainer {
                        position: relative;
                    }

                    .imgprofile {
                        width: 300px;
                        height: 300px;
                        object-fit: cover;
                        opacity: 1;
                        display: block;
                        transition: .5s ease;
                        backface-visibility: hidden;
                    }

                    .middle {
                        transition: .5s ease;
                        opacity: 0;
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        -ms-transform: translate(-50%, -50%);
                        text-align: center;
                    }

                    .imgcontainer:hover .image {
                        opacity: 0.3;
                    }

                    .imgcontainer:hover .middle {
                        opacity: 1;
                    }
                </style>


            </div>

            <div class="px-3 my-3">
                <div
                    class="justify-content-center align-items-center d-flex rounded-3 bg-semi-dark p-3 border border-1 border-primary">
                    <span class="text-primary px-2 fs-4 fw-bold d-flex justify-content-between w-100">
                        <div>
                            <i class="bi bi-gear-fill"></i>
                        </div>
                        <div>
                            Profile Settings
                        </div>

                    </span>
                </div>
            </div>



            <div class="p-4">
                <div class="row">

                    <div class="col-sm-12 col-md-3 mb-3 px-2">
                        <div
                            class="imgcontainer bg-semi-dark rounded-3 d-flex aligns-items-center justify-content-center">

                            <img
                                @if (is_null($user_info->user_photo) || empty($user_info->user_photo)) src="{{ asset('img/avatars/default_dp.jpg') }}"
                            @else
                                src="data:image/png;base64,{{ $user_info->user_photo }}" @endif
                                class="imgprofile p-2 img-fluid rounded-3 me-1 border border-1 border-primary"
                                alt="" />

                            <div class="middle">
                                <button data-bs-toggle="modal" data-bs-target="#changephoto"
                                    class="btn btn-primary">Change Photo</button>
                            </div>
                        </div>

                    </div>

                    <div class="col-sm-12 col-md-9">
                        <div class="rounded row">
                            <div>
                                <div class="bg-semi-dark p-3 rounded-3 mb-3 d-flex justify-content-end">
                                    <a data-bs-toggle="modal" data-bs-target="#modify" class="text-end">
                                        Modify Personal Info
                                    </a>
                                </div>
                            </div>

                            <div class="hrdivider m-0 mt-2">
                                <hr class="text-primary">
                                <span>
                                    <div class="d-flex align-items-center text-primary">
                                        <i class="bi bi-person-badge-fill"></i>&nbsp; Personal Info&nbsp;&nbsp;&nbsp;
                                    </div>
                                </span>
                            </div>


                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="" class="form-label"> Firstname</label>
                                <input disabled value="{{ $user_info->user_fname }}" type="text"
                                    class="form-control" id="" placeholder="">
                            </div>

                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="" class="form-label"> Lastname</label>
                                <input disabled value="{{ $user_info->user_lname }}" type="text"
                                    class="form-control" id="" placeholder="">
                            </div>

                            <div class="hrdivider m-0 mt-3">
                                <hr class="text-primary">
                                <span>
                                    <div class="d-flex align-items-center text-primary">
                                        <i class="bi bi-person-fill"></i>&nbsp; Account Info&nbsp;&nbsp;&nbsp;
                                    </div>
                                </span>
                            </div>

                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="" class="form-label">Email</label>

                                <div class="d-flex">
                                    <div class="w-100">
                                        <input disabled value="{{ $user_info->email }}" type="email" class="form-control"
                                        id="" placeholder="">
                                    </div>

                                    <span class="mx-1"></span>

                                    <div>
                                        <button data-bs-toggle="modal" data-bs-target="#changeemail" class="btn btn-primary"><i class="bi bi-gear-fill"></i></button>
                                    </div>

                                </div>
                          
                            </div>

                            <div class="mb-3 col-sm-6 col-md-3">
                                <label for="" class="form-label"> Username</label>
                                <input disabled value="{{ $user_info->username }}" type="text"
                                    class="form-control" id="" placeholder="">
                            </div>

                            <div class="mb-3 col-sm-6 col-md-3">
                                <label for="" class="form-label">Password</label>
                                <button data-bs-toggle="modal" data-bs-target="#changepassword"
                                    class="btn btn-primary w-100"><i class="bi bi-gear-fill"></i> Change</button>
                            </div>



                        </div>
                    </div>

                </div>
            </div>


            <div class="px-3 mb-3">
                <div class="bg-semi-dark p-4 rounded-3  border-bottom border-5 rounded-3 border-primary">

                </div>
            </div>



            {{-- <div class="row px-4">

                <div class="col-sm-12 col-lg-6 mt-4">
                    <div class="mb-2" style="font-size: 0.75rem">Subject and Notes</div>
                    
                    <div class="bg-semi-dark rounded p-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <div class="fw-bold">Notes & Quiz Autosave</div>
                            <div class="mx-3"></div>
                            <div class="d-flex">
                                s
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-lg-6 mt-4">
                    <div class="mb-2" style="font-size: 0.75rem">Privacy</div>
                    <div class="bg-semi-dark rounded p-3">

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fw-bold">Default Sharing</div>
                            <div class="mx-3"></div>
                            <div class="d-flex">
                                
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                    <label class="form-check-label" for="flexRadioDefault1">
                                      Public
                                    </label>
                                  </div>

                                  <div class="mx-1"></div>

                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2">
                                    <label class="form-check-label" for="flexRadioDefault2">
                                      Private
                                    </label>
                                  </div>

                       
                            </div>
                        </div>
                        

                    </div>
                </div>
            </div> --}}


        </div>
    </main>


</div>

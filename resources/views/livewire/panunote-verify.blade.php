<div>
    <div class="vh-100 p-0 m-0">
        <section class="vh-100 d-flex justify-content-center align-items-center">

            <div class="px-5">

                <img class="mb-3" style="width: 130px;" src="{{ asset('img/logos/panunote_logo_login.png') }}"
                    alt="">
                <p class="mb-4"><span class="fw-bold">Please Verify your Account.</span> Send and check your Email.</p>


           
                    @csrf

                    @if ($errors->any())
                        <div class="p-3 mb-3 bg-danger rounded-3 bg-opacity-25 border border-dark" role="alert">
                            @foreach ($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    @if (Session::has('success'))
                        <div class="p-3 mb-3 bg-primary rounded-3 bg-opacity-25 border border-primary" role="alert">
                            <div>
                                {{ Session::get('success') }}
                            </div>
                        </div>
                    @endif

                    @if (Session::has('error'))
                        <div class="p-3 mb-3 bg-danger rounded-3 bg-opacity-25 border border-dark" role="alert">
                            <div>
                                {{ Session::get('error') }}
                            </div>
                        </div>
                    @endif

                    <div class="form-group first mb-5">
                        <label for="password">Email</label>

                        <form wire:submit.prevent="sendcode"> 
                        <div class="d-flex">
                            <div class="w-100">
                                <input type="email" class="form-control mb-3" wire:model="email">
                            </div>
                            <span class="mx-1"></span>
                            <div>
                                <button id="send" type="submit" class="btn btn-primary d-flex">
                                    <span class="me-1" wire:loading wire:target="sendcode">
                                        <span id="spinner"
                                            class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                                            role="status" aria-hidden="true"></span>
                                    </span>
                                    Send
                                </button>
                            </div>
                        </div>
                </form>

                <form wire:submit.prevent="verifycode">
                    <div class="bg-semi-dark p-3 rounded-3 border-4 border-bottom border-primary">
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
                    <button type="submit" class="w-100 btn btn-primary text-light mt-3 d-flex justify-content-center">
                        <span class="me-1" wire:loading wire:target="verifycode">
                            <span id="spinner"
                                class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                                role="status" aria-hidden="true"></span>
                        </span>
                        Verify
                    </button>
                </form>

            </div>


         

            <div class="mt-3 text-end"><a href="{{ route('signout') }}">Logout</a></div>

    </div>
    </section>


</div>

</div>

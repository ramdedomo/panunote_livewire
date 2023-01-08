<div class="">

    <div class="vh-100 p-0 m-0">
        <section class="vh-100 d-flex justify-content-center align-items-center">

            <div class="px-5" x-data="{ show1: false, show2: false }">

                <img class="mb-3" style="width: 130px;" src="{{ asset('img/logos/panunote_logo_login.png') }}"
                    alt="">
                <p class="mb-4"><span class="fw-bold">Reset Password</span> please enter your new password.</p>


                <form wire:submit.prevent="resetpass">
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
                        <label for="password">New Password</label>
                        <div class="d-flex">
                            <div class="w-100 ">
                                <input :type="show1 ? 'text' : 'password'"  class="form-control mb-3" wire:model="password">
                            </div>
                            <span class="mx-1"></span>
                            <div>
                                <button type="button" @click="show1 = ! show1"  class="btn btn-primary px-2"><i :class="show1 ? 'bi bi-eye-fill' : 'bi bi-eye-slash-fill'"></i></button>
                            </div>
                        </div>


                        <label for="password">Re-enter Password</label>
                        <div class="d-flex">
                            <div class="w-100">
                                <input :type="show2 ? 'text' : 'password'"  class="form-control" wire:model="password_confirmation">
                            </div>
                            <span class="mx-1"></span>
                            <div>
                                <button type="button" @click="show2 = ! show2" class="btn btn-primary px-2"><i :class="show2 ? 'bi bi-eye-fill' : 'bi bi-eye-slash-fill'"></i></button>
                            </div>
                        </div>
                  
                    </div>

                    <button type="submit" class="btn btn-primary text-light">Reset</button>
                </form>

            </div>
        </section>


    </div>

</div>

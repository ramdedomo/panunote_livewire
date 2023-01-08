@extends('layouts.panunote_auth_master')
@section('title', 'Panunote')
@section('content')

@if(!is_null(Auth::user()))
    <script>window.location = "{{ route('subjects') }}";</script>
@endif

<div class="row h-100 p-0 m-0">


    <section class="position-relative d-flex justify-content-center align-items-center col-xl-7 col-lg-12 col-md-12">

        {{-- <div class="position-absolute bottom-0 end-0">
            <h6 class="m-0 p-4"><strong>8/17/2022</strong> 2:00 PM</h3>
        </div> --}}

        <div class="p-5">
            <img class="mb-3" style="width: 130px;" src="{{ asset('img/logos/panunote_logo_login.png') }}" alt="">
            <p class="mb-4"><span class="fw-bold">Welcome Back to Panunote!</span> Login to Continue to your Account.</p>


            <form action="{{route('signup')}}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="p-3  mb-3 bg-danger rounded-3 bg-opacity-25 border border-danger" role="alert">
                        @foreach ($errors->all() as $error)
                           <div>{{ $error }}</div> 
                        @endforeach
                    </div>
                @endif

                <div class="form-group mb-2">
                    <div class="row">
                        <div class="col">
                        <label for="firstname">Firstname</label>
                          <input placeholder="Juan" type="text" class="form-control" placeholder="Juan" name="firstname" aria-label="First name">
                        </div>
                        <div class="col">
                            <label for="lastname">Lastname</label>
                          <input placeholder="Cruz" type="text" class="form-control" placeholder="Cruz" name="lastname" aria-label="Last name">
                        </div>
                      </div>
                </div>


                <div class="form-group first mb-2">
                <label for="email">Email</label>
                <input placeholder="juancruz@gmail.com"  type="text" class="form-control" placeholder="your-email@gmail.com" name="email">
                </div>

                <div class="form-group mb-3">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>

                        <div class="col-sm-12 col-md-6">
                            <label for="confirmpassword">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                </div>


                                   

                <div class="mb-5 d-flex justify-content-between">
                <div>
                    {{-- <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                        <input type="checkbox" checked />
                        <div class="control__indicator"></div>
                    </label> --}}
                </div>

                <div>
                    <span class="ml-auto">Already have an account? <a href="{{ route('login') }}">Login</a></span>
                </div>

                </div>
 
                <button type="submit" class="btn btn-primary text-light">Signup</button>
            </form>

       </div>
    </section>

    <section class="bg-primary col-5 d-none d-xl-block" style="background-image:url({{url('img/logos/panunote_bg.png')}}); background-size: cover;">
    </section>

</div>

@endsection

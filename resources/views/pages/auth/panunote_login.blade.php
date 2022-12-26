@extends('layouts.panunote_auth_master')
@section('title', 'Panunote')
@section('content')

@if(!is_null(session('USER_ID')))
    <script>window.location = "{{ route('subjects') }}";</script>
@endif

<div class="row h-100 p-0 m-0 position-relative">
    <section class="d-flex justify-content-center align-items-center col-xl-7 col-lg-12 col-md-12">

        <div class="px-5">

            <img class="mb-3" style="width: 130px;" src="{{ asset('img/logos/panunote_logo_login.png') }}" alt="">
            <p class="mb-4"><span class="fw-bold">Welcome Back to Panunote!</span> Login to Continue to your Account.</p>


            <form action="{{route('signin')}}" method="POST">

                @csrf


                @if ($errors->any())
                    <div class="p-3 mb-3 bg-secondary rounded-3 bg-opacity-25 border border-dark" role="alert">
                        @foreach ($errors->all() as $error)
                           <div>{{ $error }}</div> 
                        @endforeach
                    </div>
                @endif



                <div class="form-group first">
                <label for="email">Email</label>
                <input type="text" class="form-control" placeholder="your-email@gmail.com" name="email">
                </div>

                <div class="form-group last mb-3">
                <label for="password">Password</label>
                
                <div class="d-flex" x-data="{ show: false }">
                    <input :type="show ? 'text' : 'password'" class="form-control" name="password">
                    <span class="mx-1"></span>
                    <button type="button" class="btn btn-primary px-2" @click="show = ! show"><i :class="show ? 'bi bi-eye-fill' : 'bi bi-eye-slash-fill' "></i></button>
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
                    <span class="ml-auto"><a href="{{ route('register') }}">Create New Account</a></span>
                </div>

                </div>
 
                <button type="submit" class="btn btn-primary text-light">Signin</button>
            </form>

       </div>
    </section>
    

    <section class="bg-primary col-5 d-none d-xl-block" style="background-image:url({{url('img/logos/panunote_bg.png')}}); background-size: cover;">
    </section>

</div>

@endsection

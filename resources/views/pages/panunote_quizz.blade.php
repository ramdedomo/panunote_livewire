@extends('layouts.panunote_master')
@section('title', 'Panunote')
@section('content')

    <main class="content">
        <div class="container-fluid">
            {{-- <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1> --}}
            <div class="sticky-top bg-white py-3">
                <div class="sizebox"></div>
                <div>
                    <div class="d-flex justify-content-between">
                        <div class="rounded p-1 bg-semi-dark">
                            <button class="btn py-1 text-light bg-primary">Quizzes Dummy</button>
                        </div>

                        <div class="rounded p-1 bg-semi-dark">
                            <button class="btn py-1 bg-primary"><i class="text-light bi bi-share"></i></button>
                            <button class="btn py-1 bg-primary"><i class="text-light bi bi-heart"></i></button>
                            <span class="mx-2">|</span>
                            <button class="btn py-1 bg-primary"><i class="text-light bi bi-journal-x"></i></button>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <div>
                            <input type="text" class="form-control fs-1 mb-2 p-0 px-2 border-1" value="Quiz Dummy">
                        </div>

                        <div>
                            <span class="badge bg-primary"><i class="bi bi-tag-fill"></i></span>
                            <span class="badge bg-primary">Programming</span>
                            <span class="badge bg-primary">Math</span>
                        </div>

                    </div>
                </div>
            </div>

            <div class="mt-3">
                <div class="row">

                    <div class="col-2"><input class="form-control border-0 bg-semi-dark" type="text"></div>
                    <div class="col-10 align-self-center">1. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua?</div>
                    <div class="my-2"></div>
                    <div class="col-2"><input class="form-control border-0 bg-semi-dark" type="text"></div>
                    <div class="col-10 align-self-center">2. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.  Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua?</div>
                </div>
            </div>
                
            </div>
    </main>





@endsection



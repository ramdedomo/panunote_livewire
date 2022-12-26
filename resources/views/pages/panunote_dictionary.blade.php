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
                        <button class="btn py-1 text-light bg-primary">Dictionary</button>
                    </div>
                </div>
                
                <div class="mt-3">
                    <div>
                        <input type="text" class="form-control fs-1 mb-2 p-0 px-2 border-1" value="Note Dummy">
                    </div>
                </div>
            </div>
        </div>
        
        <div>
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
        </div>
            
    </div>
</main>


@endsection



<div class="h-100">
    <main>
        <div class="">
            <div class="p-0 m-0 vh-100 d-flex align-items-center justify-content-center">
                <div class="">
                    <img class="mb-3" style="width: 350px;" src="{{ asset('img/logos/panugame_logo.png') }}" alt="">
                    <div class="bg-light rounded-3 p-2 shadow-md">
                        <div>
                            
                            <a href="{{ route('join') }}" class="text-decoration-none text-light">
                                <div class="fs-1 p-1 rounded-3 shadow-sm text-center mb-2 join_btn">
                                    Join
                                </div>
                            </a>

                            <a href="{{ route('create') }}" class="text-decoration-none text-light">
                                <div class="fs-1 p-1 rounded-3 shadow-sm text-center create_btn">
                                    Create
                                </div>
                            </a>


                        </div>
                    </div>

                    {{-- <div class="text-end mt-3">
                        <a class="text-light" href=""><i class="bi bi-question-circle"></i> How it works?</a>
                    </div> --}}


                </div>

            </div>
        </div>
    </main>
    
</div>
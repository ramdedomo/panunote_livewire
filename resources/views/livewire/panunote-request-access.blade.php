<div class="vh-100 vw-100 d-flex justify-content-center align-items-center">

    <div class="px-5" x-data="{ show1: false, show2: false }">

        <img class="mb-3" style="width: 130px;" src="{{ asset('img/logos/panunote_logo_login.png') }}"
            alt="">
   
        @if($exists)
        <p class="mb-4"><span class="fw-bold">Request Succesful.</span> please Wait until you get Access.</p>
        <div class="bg-primary bg-opacity-25 border border-1 text-primary border-primary rounded-3 p-2 text-center">
            <span class="fw-bold"> Already Requested.</span>
        </div>

        <div class="d-flex justify-content-end align-items-center mt-3">
            <a href="/community" class="btn p-0 btn-link">To Community <i class="bi bi-arrow-right-circle"></i></a>
        </div>

        @else
        <p class="mb-4"><span class="fw-bold">Request Access.</span> click the request button to request access.</p>
        <div class="bg-semi-dark rounded-3 p-2 d-flex justify-content-between">
            <div>
                @switch($type)

                @case('subject')
                    Subject: <span class="fw-bold">{{$this->details->subject_name}}</span>
 
                    @break
 
                @case('note')
                    Note: <span class="fw-bold">{{$this->details->note_title}}</span>
                    @break
 
                @case('quiz')
                    Quiz: <span class="fw-bold">{{$this->details->quiz_title}}</span>
                    @break
 
                    @endswitch
            </div>

            <div class="d-flex">
                 <span class="fw-bold">{{$user->username}}</span>
                 <span class="mx-1"></span>

                 @if (is_null($user->user_photo) || empty($user->user_photo))
                 <div class="icon">
                 <img style="object-fit: cover;" width="20px" height="20px" class="border border-2 border-primary rounded-5"
                     src="{{ asset('img/avatars/default_dp.jpg') }}"
                     alt="">
                 </div>
                 @else
                 <div class="icon">
                 <img style="object-fit: cover;" width="20px" height="20px" class="border border-2 border-primary  rounded-5"
                 src="data:image/png;base64,{{ $user->user_photo }}"
                 alt="">
                 </div>
                 @endif
            </div>
        </div>

        <div class="mt-3">
            <button wire:click="request_access" class="btn-primary btn w-100">Request Access</button>
        </div>

        <div class="d-flex justify-content-end align-items-center mt-3">
            <a href="/community" class="btn p-0 btn-link">To Community <i class="bi bi-arrow-right-circle"></i></a>
        </div>
        @endif



    </div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}
</div>

<div>
    <main class="">
      <div class="">
        <div class="sticky-top bg-white p-0 m-0">
          <div class="sizebox"></div>
        </div>

        <div class="p-3">
          <div class="hrdivider">
            <hr class="text-primary">
            <span>
              <div class="d-flex align-items-center bg-light text-primary fs-4">
                Community&nbsp;&nbsp;&nbsp;
              </div>
            </span>
          </div>

          <div class="p-2 d-flex justify-content-between rounded-3 bg-semi-dark mb-2">

            <div>
              <div class="d-flex">
                <input wire:model.debounce.500ms="search" class="search form-control" type="text"
                  placeholder="Find Subjects, Note and Quiz" aria-label="default input example">
                <span class="mx-1"></span>
                <button id="searchword" class="py-1 px-2 btn btn-primary">
                  <span wire:loading>
                    <div id="spinner"
                      class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                      role="status" aria-hidden="true"></div>
                  </span>
                  <i wire:loading.remove class="bi bi-search"></i>
                </button>
              </div>
            </div>

            <div>
              <div class="btn-group">
                <a wire:click="topsubjects('weekly')"
                @if ($weekly) class='btn btn-primary active'
                @else
                class='btn btn-primary' @endif
                aria-current="page">
                This Week</a>
                <a wire:click="topsubjects('monthly')"
                @if ($monthly) class='btn btn-primary active'
                @else
                class='btn btn-primary' @endif
                aria-current="page">
                This Month</a>
                <a wire:click="topsubjects('yearly')"
                @if ($yearly) class='btn btn-primary active'
                @else
                class='btn btn-primary' @endif
                aria-current="page">
                This Year</a>
              </div>
            </div>

          </div>


          <div
            class="p-2 d-flex border-bottom border-3 border-primary align-items-center rounded-3 justify-content-center bg-semi-dark mb-5">
            <div class="text-secondary w-100">
              @if ($subjects->isEmpty() && $notes->isEmpty() && $quizzes->isEmpty() && !empty($this->search))
              <span class="d-flex justify-content-center fw-bold">
              Empty
              </span>
              @endif
              @if ($subjects->isEmpty() && $notes->isEmpty() && $quizzes->isEmpty() && empty($this->search))
              <span class="d-flex justify-content-center fw-bold">
              Search Subject, Notes, Quizzes or Tags
              </span>
              @else
              <div>
                @if (!$subjects->isEmpty())
                <div class="hrdivider">
                  <hr class="text-primary">
                  <span>
                    <div class="d-flex align-items-center bg-semi-dark text-primary">
                      Subjects&nbsp;&nbsp;&nbsp;
                    </div>
                  </span>
                </div>
                <div class="row g-2">
                  @foreach ($subjects as $subject)
                  <div class="col-3">
                    <div class="p-0 m-0 card note-card rounded-3 border border-1 border-primary"
                      style="--bs-border-opacity: .2;">
                      <div
                        class="card-header border-bottom border-primary border-2 d-flex justify-content-between">
                        <div>
                          <p class="p-0 m-0 fw-bold" id="title">
                            {{ $subject->subject_name }}
                          </p>
                        </div>
                        <div>
                          <p class="p-0 m-0" id="title">
                            @if (Auth::user()->user_id == $subject->user_id)
                            <i class="bi bi-person-check-fill text-primary"></i>
                            {{ $subject->username }}
                            @else
                            <i class="bi bi-person-fill"></i>
                            {{ $subject->username }}
                            @endif
                          </p>
                        </div>
                      </div>
                      <div class="card-body">
                      </div>
                      <a href="/subjects/{{ $subject->subject_id }}" target="_blank"
                        class="stretched-link"></a>
                    </div>
                  </div>
                  @endforeach
                </div>
                @endif
              </div>
              <div>
                @if (!$notes->isEmpty())
                <div class="hrdivider">
                  <hr class="text-warning">
                  <span>
                    <div class="d-flex align-items-center bg-semi-dark text-warning">
                      Notes&nbsp;&nbsp;&nbsp;
                    </div>
                  </span>
                </div>
                <div class="row mb-4 g-2">
                  @foreach ($notes as $note)
                  <div class="col-3">
                    <div class="p-0 m-0 card note-card rounded-3 border border-1 border-warning"
                      style="--bs-border-opacity: .2;">
                      <div
                        class="card-header border-bottom border-warning border-2 d-flex justify-content-between">
                        <div>
                          <p class="p-0 m-0 fw-bold" id="title">
                            {{ $note->note_title }}
                          </p>
                        </div>
                        <div>
                          <p class="p-0 m-0" id="title">
                            @if (Auth::user()->user_id == $note->user_id)
                            <i class="bi bi-person-check-fill text-warning"></i>
                            {{ $note->username }}
                            @else
                            <i class="bi bi-person-fill"></i>
                            {{ $note->username }}
                            @endif
                          </p>
                        </div>
                      </div>
                      <div class="card-body">
                      </div>
                      <a href="/subjects/{{ $note->subject_id }}/{{ $note->note_id }}"
                        target="_blank" class="stretched-link"></a>
                    </div>
                  </div>
                  @endforeach
                </div>
                @endif
              </div>
              <div>
                @if (!$quizzes->isEmpty())
                <div class="hrdivider">
                  <hr class="text-info">
                  <span>
                    <div class="d-flex align-items-center bg-semi-dark text-info">
                      Quizzes&nbsp;&nbsp;&nbsp;
                    </div>
                  </span>
                </div>
                <div class="row mb-4 g-2">
                  @foreach ($quizzes as $quiz)
                  <div class="col-3">
                    <div class="p-0 m-0 card note-card rounded-3 border border-1 border-info"
                      style="--bs-border-opacity: .2;">
                      <div
                        class="card-header border-bottom border-info border-2 d-flex justify-content-between">
                        <div>
                          <p class="p-0 m-0 fw-bold" id="title">
                            {{ $quiz->quiz_title }}
                          </p>
                        </div>
                        <div>
                          <p class="p-0 m-0" id="title">
                            @if (Auth::user()->user_id == $quiz->user_id)
                            <i class="bi bi-person-check-fill text-info"></i>
                            {{ $quiz->username }}
                            @else
                            <i class="bi bi-person-fill"></i>
                            {{ $quiz->username }}
                            @endif
                          </p>
                        </div>
                      </div>
                      <div class="card-body">
                      </div>
                      <a href="/quizzes/{{ $quiz->quiz_id }}" target="_blank"
                        class="stretched-link"></a>
                    </div>
                  </div>
                  @endforeach
                </div>
                @endif
              </div>
              @endif
            </div>
          </div>

          
    
           

        <div class="row">

            <div class="col-md-12 col-lg-6 rounded-3 d-block d-md-block d-lg-none">
                <div class="justify-content-center align-items-center d-flex rounded-3 mb-3"
                style="background-size: cover; height: 100px; background-image: url({{ asset('img/logos/panugame_banner2.png') }})">
                <span class="fs-2 fw-bold text-light">
                    <i class="bi bi-journals"></i>

                    Top of the
                    @if ($weekly)
                        Week!
                    @elseif ($monthly)
                        Month!
                    @elseif ($yearly)
                        Year!
                    @else
                        Unknown!
                    @endif

                </span>
                </div>
            </div>


            <div class="col-md-12 col-lg-6 rounded-3  d-none d-lg-block">
                <div class="justify-content-center align-items-center d-flex rounded-3 mb-3"
                style="background-size: cover; height: 100px; background-image: url({{ asset('img/logos/panugame_banner2.png') }})">
                <span class="fs-2 fw-bold text-light">
                    <i class="bi bi-journals"></i>

                    Top Visits of the
                    @if ($weekly)
                        Week!
                    @elseif ($monthly)
                        Month!
                    @elseif ($yearly)
                        Year!
                    @else
                        Unknown!
                    @endif

                </span>
                </div>
            </div>

            <div class="col-md-12 col-lg-6 rounded-3  d-none d-lg-block">
                <div class="justify-content-center align-items-center d-flex rounded-3 mb-3"
                style="background-size: cover; height: 100px; background-image: url({{ asset('img/logos/panugame_banner1.png') }})">
                <span class="fs-2 fw-bold text-light">
                    <i class="bi bi-journals"></i>

                   Top Likes of the
                    @if ($weekly)
                        Week!
                    @elseif ($monthly)
                        Month!
                    @elseif ($yearly)
                        Year!
                    @else
                        Unknown!
                    @endif

                </span>
                </div>
            </div>
        </div>

          {{-- subjects --}}


          <div class="hrdivider">
            <hr class="text-primary">
            <span>
              <div class="d-flex align-items-center bg-light text-primary fs-4">
                Subjects&nbsp;&nbsp;&nbsp;
              </div>
            </span>
          </div>

        <div class="row">
            <div class="col-md-12 col-lg-6 rounded-3">
            
                <div class="p-2 bg-semi-dark rounded-3 d-block d-md-block d-lg-none text-center fw-bold text-primary"><i class="bi bi-heart-fill"></i> TOP SUBJECT LIKES</div>
           
                @if (!$islikeempty)
                <div class="col-12 my-2 bg-semi-dark p-2 rounded-3">
                    <div class="row g-2">
                            @php
                            $count = 1;
                            @endphp
                            @foreach ($toplikes as $topl)
                                <div class="col-6">
                                <div class="browse-picker card p-3 mb-2 border-bottom border-5 border-primary">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row align-items-center">
                                            @if (is_null($topl->user_info[0]['user_photo']) || empty($topl->user_info[0]['user_photo']))
                                            <div class="icon">
                                            <img style="object-fit: cover;" width="40px" height="40px" class="rounded-5"
                                                src="{{ asset('img/avatars/default_dp.jpg') }}"
                                                alt="">
                                            </div>
                                            @else
                                            <div class="icon">
                                            <img style="object-fit: cover;" width="40px" height="40px" class="rounded-5"
                                            src="data:image/png;base64,{{ $topl->user_info[0]['user_photo'] }}"
                                            alt="">
                                            </div>
                                            @endif

                                            <div class="ms-2 c-details">
                                            @if (Auth::user()->user_id == $topl->user_info[0]['user_id'])
                                            <strong class="text-primary">{{ ucfirst($topl->user_info[0]['username']) }}</strong>
                                            @else
                                            <strong>{{ ucfirst($topl->user_info[0]['username']) }}</strong>
                                            @endif
                                            <br>
                                            <span>{{ date_format($topl->updated_at, 'm/d h:i A') }}</span>
                                            </div>
                                        </div>

                                        <span class="fs-3 fw-bold text-primary rounded-2 px-2 d-flex align-items-center">
                                            @if ($count == 1)
                                            <span class="badge text-bg-primary">#{{ $count }}</span>
                                            @elseif($count == 2)
                                            <span class="badge text-bg-primary">#{{ $count }}</span>
                                            @elseif($count == 3)
                                            <span class="badge text-bg-primary">#{{ $count }}</span>
                                            @else
                                            <span class="badge text-bg-primary">#{{ $count }}</span>
                                            @endif
                                        </span>
                                    </div>
                                  
                                <div class="mt-3">
                                    <h3 class="d-flex heading p-0 text-dark align-items-center justify-content-center text-center" style="height: 80px"><strong>{{ substr($topl->subject_name, 0, 35) }}</strong> </h3>
                                    {{-- <p>{{ str_word_count($topv->note_content) }} Words</p> --}}
                                    <div class="mt-3">
                                    <div class="d-flex fw-4">
                                        <div class=" w-100">
                                        <i class="bi bi-heart-fill text-primary text-primary"></i>
                                        <span class="mx-1"><strong>{{ $topl->like_count }}</strong> Likes</span>
                                        </div>
                                        <div class="bg-semi-dark d-flex w-100 rounded-4">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <a href="/subjects/{{ $topl->subject_id }}" class="stretched-link"></a>
                                </div>
                            </div>
                          @php
                          $count++;
                          @endphp
                          @endforeach
                    </div>
                </div>
                @else
                    <div
                        class="fw-bold mb-3 p-3 bg-semi-dark rounded-3 d-flex justify-content-center align-items-center">
                        <i class="bi bi-bar-chart-line"></i>&nbsp;&nbsp; No Data
                    </div>
                @endif
            
  

            </div>

            <div class="col-md-12 col-lg-6 rounded-3">
            
                <div class="p-2 bg-semi-dark rounded-3 d-block d-md-block d-lg-none text-center fw-bold text-primary"><i class="bi bi-bar-chart-fill"></i>  TOP SUBJECT VISITS</div>
                @if (!$isvisitempty)
                <div class="col-12 my-2 bg-semi-dark p-2 rounded-3">
                    <div class="row g-2">
                            @php
                            $count = 1;
                            @endphp
                            @foreach ($topvisits as $topv)
                                <div class="col-6">
                                <div class="browse-picker card p-3 mb-2 border-bottom border-5 border-primary">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row align-items-center">
                                            @if (is_null($topv->user_info[0]['user_photo']) || empty($topv->user_info[0]['user_photo']))
                                            <div class="icon">
                                            <img style="object-fit: cover;" width="40px" height="40px" class="rounded-5"
                                                src="{{ asset('img/avatars/default_dp.jpg') }}"
                                                alt="">
                                            </div>
                                            @else
                                            <div class="icon">
                                            <img style="object-fit: cover;" width="40px" height="40px" class="rounded-5"
                                            src="data:image/png;base64,{{ $topv->user_info[0]['user_photo'] }}"
                                            alt="">
                                            </div>
                                            @endif
                                            <div class="ms-2 c-details">
                                                @if (Auth::user()->user_id == $topv->user_info[0]['user_id'])
                                                <strong class="text-primary">{{ ucfirst($topv->user_info[0]['username']) }}</strong>
                                                @else
                                                <strong>{{ ucfirst($topv->user_info[0]['username']) }}</strong>
                                                @endif
                                                <br>
                                                <span>{{ date_format($topv->updated_at, 'm/d h:i A') }}</span>
                                            </div>
                                        </div>
                                    
                                        <span class="fs-3 fw-bold text-primary rounded-2 px-2 d-flex align-items-center">
                                            @if ($count == 1)
                                            <span class="badge text-bg-primary">#{{ $count }}</span>
                                            @elseif($count == 2)
                                            <span class="badge text-bg-primary">#{{ $count }}</span>
                                            @elseif($count == 3)
                                            <span class="badge text-bg-primary">#{{ $count }}</span>
                                            @else
                                            <span class="badge text-bg-primary">#{{ $count }}</span>
                                            @endif
                                            </span>
                                    </div>
  
                             
                                <div class="mt-3">
                                    <h3 class="d-flex heading p-0 text-dark align-items-center justify-content-center text-center" style="height: 80px"><strong>{{ substr($topv->subject_name, 0, 35) }}</strong> </h3>
                                    {{-- <p>{{ str_word_count($topv->note_content) }} Words</p> --}}
                                    <div class="mt-3">
                                    <div class="d-flex fw-4">
                                        <div class=" w-100">
                                        <i class="bi bi-bar-chart-fill text-primary text-primary"></i>
                                        <span class="mx-1"><strong>{{ $topv->visit_count }}</strong> Visits</span>
                                        </div>
                                        <div class="bg-semi-dark d-flex w-100 rounded-4">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <a href="/subjects/{{ $topv->subject_id }}" class="stretched-link"></a>
                                </div>
                            </div>
                          @php
                          $count++;
                          @endphp
                          @endforeach
                    </div>
                </div>
                @else
                    <div
                        class="fw-bold mb-3 p-3 bg-semi-dark rounded-3 d-flex justify-content-center align-items-center">
                        <i class="bi bi-bar-chart-line"></i>&nbsp;&nbsp; No Data
                    </div>
                @endif
            
  

            </div>
        </div>




          {{-- notes --}}

          <div class="hrdivider">
            <hr class="text-primary">
            <span>
              <div class="d-flex align-items-center bg-light text-primary fs-4">
                Notes&nbsp;&nbsp;&nbsp;
              </div>
            </span>
          </div>

        <div class="row">
            <div class="col-md-12 col-lg-6 rounded-3">
           
                @if (!$isnotelikeempty)
                <div class="p-2 bg-semi-dark rounded-3 d-block d-md-block d-lg-none text-center fw-bold text-primary"><i class="bi bi-heart-fill"></i> TOP NOTE LIKES</div>

                <div class="col-12 my-2 bg-semi-dark p-2 rounded-3">
                    <div class="row g-2">
                            @php
                            $count = 1;
                            @endphp
                            @foreach ($note_toplikes as $topl)
                                <div class="col-6">
                                <div class="browse-picker card p-3 mb-2 border-bottom border-5 border-warning">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row align-items-center">
                                            @if (is_null($topl->user_info[0]['user_photo']) || empty($topl->user_info[0]['user_photo']))
                                            <div class="icon">
                                            <img style="object-fit: cover;" width="40px" height="40px" class="rounded-5"
                                                src="{{ asset('img/avatars/default_dp.jpg') }}"
                                                alt="">
                                            </div>
                                            @else
                                            <div class="icon">
                                            <img style="object-fit: cover;" width="40px" height="40px" class="rounded-5"
                                            src="data:image/png;base64,{{ $topl->user_info[0]['user_photo'] }}"
                                            alt="">
                                            </div>
                                            @endif

                                            <div class="ms-2 c-details">
                                                @if (Auth::user()->user_id == $topl->user_info[0]['user_id'])
                                                <strong class="text-warning">{{ ucfirst($topl->user_info[0]['username']) }}</strong>
                                                @else
                                                <strong>{{ ucfirst($topl->user_info[0]['username']) }}</strong>
                                                @endif
                                                <br>
                                                <span>{{ date_format($topl->updated_at, 'm/d h:i A') }}</span>
                                            </div>
                                        </div>
                                    
                                        <span class="fs-3 fw-bold text-warning rounded-2 px-2 d-flex align-items-center">
                                            @if ($count == 1)
                                            <span class="badge text-light bg-warning">#{{ $count }}</span>
                                            @elseif($count == 2)
                                            <span class="badge text-light bg-warning">#{{ $count }}</span>
                                            @elseif($count == 3)
                                            <span class="badge text-light bg-warning">#{{ $count }}</span>
                                            @else
                                            <span class="badge text-light bg-warning">#{{ $count }}</span>
                                            @endif
                                            </span>
                                    </div>

                             

                                <div class="mt-3">
                                    <h3 class="d-flex heading p-0 text-dark align-items-center justify-content-center text-center" style="height: 80px"><strong>{{ substr($topl->note_title, 0, 35) }}</strong> </h3>
                                    <p>{{ str_word_count($topl->note_content) }} Words</p>
                                    <div class="mt-3">
                                    <div class="d-flex fw-4">
                                        <div class=" w-100">
                                        <i class="bi bi-heart-fill text-warning"></i>
                                        <span class="mx-1"><strong>{{ $topl->like_count }}</strong> Likes</span>
                                        </div>
                                        <div class="bg-semi-dark d-flex w-100 rounded-4">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <a href="/subjects/{{ $topl->subject_id }}/{{ $topl->note_id }}" class="stretched-link"></a>
                                </div>
                            </div>
                          @php
                          $count++;
                          @endphp
                          @endforeach
                    </div>
                </div>
                @else
                    <div
                        class="fw-bold mb-3 p-3 bg-semi-dark rounded-3 d-flex justify-content-center align-items-center">
                        <i class="bi bi-bar-chart-line"></i>&nbsp;&nbsp; No Data
                    </div>
                @endif
            
  

            </div>

            <div class="col-md-12 col-lg-6 rounded-3">
            
                <div class="p-2 bg-semi-dark rounded-3 d-block d-md-block d-lg-none text-center fw-bold text-primary"><i class="bi bi-bar-chart-fill"></i> TOP NOTE VISITS</div>
           
                @if (!$isnotevisitempty)
                <div class="col-12 my-2 bg-semi-dark p-2 rounded-3">
                    <div class="row g-2">
                            @php
                            $count = 1;
                            @endphp
                            @foreach ($note_topvisits as $topv)
                                <div class="col-6">
                                <div class="browse-picker card p-3 mb-2 border-bottom border-5 border-warning">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row align-items-center">
                                            @if (is_null($topv->user_info[0]['user_photo']) || empty($topv->user_info[0]['user_photo']))
                                            <div class="icon">
                                            <img style="object-fit: cover;" width="40px" height="40px" class="rounded-5"
                                                src="{{ asset('img/avatars/default_dp.jpg') }}"
                                                alt="">
                                            </div>
                                            @else
                                            <div class="icon">
                                            <img style="object-fit: cover;" width="40px" height="40px" class="rounded-5"
                                            src="data:image/png;base64,{{ $topv->user_info[0]['user_photo'] }}"
                                            alt="">
                                            </div>
                                            @endif

                                            <div class="ms-2 c-details">
                                                @if (Auth::user()->user_id == $topv->user_info[0]['user_id'])
                                                <strong class="text-warning">{{ ucfirst($topv->user_info[0]['username']) }}</strong>
                                                @else
                                                <strong>{{ ucfirst($topv->user_info[0]['username']) }}</strong>
                                                @endif
                                                <br>
                                                <span>{{ date_format($topv->updated_at, 'm/d h:i A') }}</span>
                                            </div>
                                        </div>
                                    
                             <span class="fs-3 fw-bold text-warning rounded-2 px-2 d-flex align-items-center">
                                    @if ($count == 1)
                                    <span class="badge text-light bg-warning">#{{ $count }}</span>
                                    @elseif($count == 2)
                                    <span class="badge text-light bg-warning">#{{ $count }}</span>
                                    @elseif($count == 3)
                                    <span class="badge text-light bg-warning">#{{ $count }}</span>
                                    @else
                                    <span class="badge text-light bg-warning">#{{ $count }}</span>
                                    @endif
                                    </span>
                                    </div>
                                  
                                <div class="mt-3">
                                    <h3 class="d-flex heading p-0 text-dark align-items-center justify-content-center text-center" style="height: 80px"><strong>{{ substr($topv->note_title, 0, 35) }}</strong> </h3>
                                    <p>{{ str_word_count($topv->note_content) }} Words</p>
                                    <div class="mt-3">
                                    <div class="d-flex fw-4">
                                        <div class=" w-100">
                                         
                                        <i class="bi bi-bar-chart-fill text-warning"></i>
                                        <span class="mx-1"><strong>{{ $topv->visit_count }}</strong> Visits</span>
                                        </div>
                                        <div class="bg-semi-dark d-flex w-100 rounded-4">
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <a href="/subjects/{{ $topv->subject_id }}/{{ $topv->note_id }}" class="stretched-link"></a>
                                </div>
                            </div>
                          @php
                          $count++;
                          @endphp
                          @endforeach
                    </div>
                </div>
                @else
                    <div
                        class="fw-bold mb-3 p-3 bg-semi-dark rounded-3 d-flex justify-content-center align-items-center">
                        <i class="bi bi-bar-chart-line"></i>&nbsp;&nbsp; No Data
                    </div>
                @endif
            
  

            </div>
        </div>

        {{-- quizzes --}}

        <div class="hrdivider">
            <hr class="text-primary">
            <span>
              <div class="d-flex align-items-center bg-light text-primary fs-4">
                Quizzes&nbsp;&nbsp;&nbsp;
              </div>
            </span>
          </div>

        <div class="">
            <div class="row">
                <div class="col-md-12 col-lg-6 rounded-3">
                
                    <div class="p-2 bg-semi-dark rounded-3 d-block d-md-block d-lg-none text-center fw-bold text-primary"><i class="bi bi-heart-fill"></i> TOP QUIZ LIKES</div>

                    @if (!$isquizlikeempty)
                    <div class="col-12 my-2 bg-semi-dark p-2 rounded-3">
                        <div class="row g-2">
                                @php
                                $count = 1;
                                @endphp
                                @foreach ($quiz_toplikes as $topl)
                                    <div class="col-6">
                                    <div class="browse-picker card p-3 mb-2 border-bottom border-5 border-info">
                                        <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row align-items-center">
                                            @if (is_null($topl->user_info[0]['user_photo']) || empty($topl->user_info[0]['user_photo']))
                                            <div class="icon">
                                            <img style="object-fit: cover;" width="40px" height="40px" class="rounded-5"
                                                src="{{ asset('img/avatars/default_dp.jpg') }}"
                                                alt="">
                                            </div>
                                            @else
                                            <div class="icon">
                                            <img style="object-fit: cover;" width="40px" height="40px" class="rounded-5"
                                            src="data:image/png;base64,{{ $topl->user_info[0]['user_photo'] }}"
                                            alt="">
                                            </div>
                                            @endif

                                              
                                            <div class="ms-2 c-details">
                                                @if (Auth::user()->user_id == $topl->user_info[0]['user_id'])
                                                <strong class="text-info">{{ ucfirst($topl->user_info[0]['username']) }}</strong>
                                                @else
                                                <strong>{{ ucfirst($topl->user_info[0]['username']) }}</strong>
                                                @endif
                                                <br>
                                                <span>{{ date_format($topl->updated_at, 'm/d h:i A') }}</span>
                                            </div>
                                        </div>

                                            <span class="fs-3 fw-bold text-info rounded-2 px-2 d-flex align-items-center">
                                                @if ($count == 1)
                                                <span class="badge text-light bg-info">#{{ $count }}</span>
                                                @elseif($count == 2)
                                                <span class="badge text-light bg-info">#{{ $count }}</span>
                                                @elseif($count == 3)
                                                <span class="badge text-light bg-info">#{{ $count }}</span>
                                                @else
                                                <span class="badge text-light bg-info">#{{ $count }}</span>
                                                @endif
                                            </span>
                                        </div>
                            
                                    
                                    <div class="mt-3">
                                        <h3 class="d-flex heading p-0 text-dark align-items-center justify-content-center text-center" style="height: 80px"><strong>{{ substr($topl->quiz_title, 0, 35) }}</strong> </h3>
                                        {{-- <p>{{ str_word_count($topv->note_content) }} Words</p> --}}
                                        <div class="mt-3">
                                        <div class="d-flex fw-4">
                                            <div class=" w-100">
                                            <i class="bi bi-heart-fill text-info"></i>
                                            <span class="mx-1"><strong>{{ $topl->like_count }}</strong> Likes</span>
                                            </div>
                                            <div class="bg-semi-dark d-flex w-100 rounded-4">
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <a href="/quizzes/{{ $topl->quiz_id }}" class="stretched-link"></a>
                                    </div>
                                </div>
                            @php
                            $count++;
                            @endphp
                            @endforeach
                        </div>
                    </div>
                    @else
                        <div
                            class="fw-bold mb-3 p-3 bg-semi-dark rounded-3 d-flex justify-content-center align-items-center">
                            <i class="bi bi-bar-chart-line"></i>&nbsp;&nbsp; No Data
                        </div>
                    @endif
                
    

                </div>

                <div class="col-md-12 col-lg-6 rounded-3">

                    <div class="p-2 bg-semi-dark rounded-3 d-block d-md-block d-lg-none text-center fw-bold text-primary"><i class="bi bi-bar-chart-fill"></i> TOP QUIZ VISITS</div>
               
            
                    @if (!$isquizvisitempty)
                    <div class="col-12 my-2 bg-semi-dark p-2 rounded-3">
                        <div class="row g-2">
                                @php
                                $count = 1;
                                @endphp
                                @foreach ($quiz_topvisits as $topv)
                                    <div class="col-6">
                                    <div class="browse-picker card p-3 mb-2 border-bottom border-5 border-info">
                                        <div class="d-flex justify-content-between">
                                        <div class="d-flex flex-row align-items-center">
                                            @if (is_null($topv->user_info[0]['user_photo']) || empty($topv->user_info[0]['user_photo']))
                                            <div class="icon">
                                            <img style="object-fit: cover;" width="40px" height="40px" class="rounded-5"
                                                src="{{ asset('img/avatars/default_dp.jpg') }}"
                                                alt="">
                                            </div>
                                            @else
                                            <div class="icon">
                                            <img style="object-fit: cover;" width="40px" height="40px" class="rounded-5"
                                            src="data:image/png;base64,{{ $topv->user_info[0]['user_photo'] }}"
                                            alt="">
                                            </div>
                                            @endif

                                            
                                        <div class="ms-2 c-details">
                                            @if (Auth::user()->user_id == $topv->user_info[0]['user_id'])
                                            <strong class="text-info">{{ ucfirst($topv->user_info[0]['username']) }}</strong>
                                            @else
                                            <strong>{{ ucfirst($topv->user_info[0]['username']) }}</strong>
                                            @endif
                                            <br>
                                            <span>{{ date_format($topv->updated_at, 'm/d h:i A') }}</span>
                                        </div>
                                        </div>
                                        <span class="fs-3 fw-bold text-info rounded-2 px-2 d-flex align-items-center">
                                            @if ($count == 1)
                                            <span class="badge text-light bg-info">#{{ $count }}</span>
                                            @elseif($count == 2)
                                            <span class="badge text-light bg-info">#{{ $count }}</span>
                                            @elseif($count == 3)
                                            <span class="badge text-light bg-info">#{{ $count }}</span>
                                            @else
                                            <span class="badge text-light bg-info">#{{ $count }}</span>
                                            @endif
                                            </span>
                                        </div>
                         
                                    <div class="mt-3">
                                        <h3 class="d-flex heading p-0 text-dark align-items-center justify-content-center text-center" style="height: 80px"><strong>{{ substr($topv->quiz_title, 0, 35) }}</strong> </h3>
                                        {{-- <p>{{ str_word_count($topv->note_content) }} Words</p> --}}
                                        <div class="mt-3">
                                        <div class="d-flex fw-4">
                                            <div class=" w-100">
                                            <i class="bi bi-bar-chart-fill text-info"></i>
                                            <span class="mx-1"><strong>{{ $topv->visit_count }}</strong> Visits</span>
                                            </div>
                                            <div class="bg-semi-dark d-flex w-100 rounded-4">
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <a href="/quizzes/{{ $topv->quiz_id }}" class="stretched-link"></a>
                                    </div>
                                </div>
                            @php
                            $count++;
                            @endphp
                            @endforeach
                        </div>
                    </div>
                    @else
                        <div
                            class="fw-bold mb-3 p-3 bg-semi-dark rounded-3 d-flex justify-content-center align-items-center">
                            <i class="bi bi-bar-chart-line"></i>&nbsp;&nbsp; No Data
                        </div>
                    @endif
                
    

                </div>
            </div>
        </div>


      </div>
  </main>
  </div>
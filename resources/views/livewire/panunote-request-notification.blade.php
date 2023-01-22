<div>
    <li class="nav-item dropdown">
        <a class="nav-icon dropdown-toggle" href="#" id="messagesDropdown" data-bs-toggle="dropdown">
            <div class="position-relative">
                <i class="align-middle text-primary" data-feather="send"></i>
                     {{-- <span class="indicator">1</span> --}}
            </div>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end py-0" aria-labelledby="messagesDropdown">
            <div class="dropdown-menu-header">
                <div class="position-relative">
                    Recent Request Access
                </div>
            </div>

            <div class="rounded-0 bg-semi-dark fw-bold px-3 py-1 d-flex justify-content-between">
                <div>
                    <i class="bi bi-journals"></i> Subjects
                </div>
          
                <div>
              
                </div>
            </div>

            
            <div class="list-group">

                @foreach ($subject_access as $subject)
                <a href="{{route('requestlist')}}" class="list-group-item">
                    <div class="row g-0 align-items-center">
                        <div class="col-12">
                            <div class="text-primary d-flex justify-content-between align-items-center">
                                <div class="fw-bold">
                                    {{$subject->subject_name}}
                                </div>

                                <div>
                                    <i class="bi bi-person-fill"></i> {{$subject->username}}
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

            <div class="rounded-0 bg-semi-dark fw-bold px-3 py-1 d-flex justify-content-between">
                <div>
                    <i class="bi bi-journal"></i>  Notes
                </div>
          
                <div>
           
                </div>
            </div>

            <div class="list-group">

                @foreach ($note_access as $note)
                <a href="{{route('requestlist')}}" class="list-group-item">
                    <div class="row g-0 align-items-center">
                        <div class="col-12">
                            <div class="text-primary d-flex justify-content-between align-items-center">
                                <div class="fw-bold">
                                    {{$note->note_title}}
                                </div>

                                <div>
                                    <i class="bi bi-person-fill"></i> {{$note->username}}
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>

          

           <div class="rounded-0 bg-semi-dark fw-bold px-3 py-1 d-flex justify-content-between">
                <div>
                    <i class="bi bi-question-square"></i> Quizzes
                </div>
                <div>
                 
                </div>
            </div>

            <div class="list-group">

                @foreach ($quiz_access as $quiz)
                <a href="{{route('requestlist')}}" class="list-group-item">
                    <div class="row g-0 align-items-center">
                        <div class="col-12">
                            <div class="text-primary d-flex justify-content-between align-items-center">
                                <div class="fw-bold">
                                    {{$quiz->quiz_title}}
                                </div>

                                <div>
                                    <i class="bi bi-person-fill"></i> {{$quiz->username}}
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>


            <div class="dropdown-menu-footer">
                <a href="{{route('requestlist')}}" class="text-muted">All Request</a>
            </div>


        </div>
    </li>
</div>

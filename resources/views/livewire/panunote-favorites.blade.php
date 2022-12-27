<div>
    <main class="">
        <div class="">
            {{-- <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1> --}}
            <div class="sticky-top bg-white p-0 m-0">
                <div class="sizebox"></div>
                <div class="p-3 m-0">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link disabled fw-bold text-primary"><i class="bi bi-heart-fill"></i>
                                Favorites</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="subjects-tab" data-bs-toggle="tab"
                                data-bs-target="#subjects-tab-pane" type="button" role="tab"
                                aria-controls="subjects-tab-pane" aria-selected="true">Subjects</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="notes-tab" data-bs-toggle="tab"
                                data-bs-target="#notes-tab-pane" type="button" role="tab"
                                aria-controls="notes-tab-pane" aria-selected="false">Notes</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="quizzes-tab" data-bs-toggle="tab"
                                data-bs-target="#quizzes-tab-pane" type="button" role="tab"
                                aria-controls="quizzes-tab-pane" aria-selected="false">Quizzes</button>
                        </li>


                    </ul>
                </div>
            </div>

            <div class="p-3">

                <div>

                    <div class="tab-content" id="myTabContent">

                        <div class="tab-pane fade show active" id="subjects-tab-pane" role="tabpanel"
                            aria-labelledby="subjects-tab" tabindex="0">
                            <div class="row">

                                @if (!$isSubempty)
                                    @foreach ($likeSubjects as $subject)
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                            <div class="card note-card rounded-3 border border-1 border-primary border-opacity-25">
                                                <div
                                                    class="card-header border-bottom border-primary border-2 d-flex justify-content-between">
                                                    <div>
                                                        <p class="p-0 m-0 fw-bold" id="title">
                                                            {{-- @if (session('USER_ID') == $subject->subject_content[0]->user_id)
                                                            <span class="fw-bold text-primary">
                                                                **
                                                            </span>
                                                        @endif --}}
                                                            {{ $subject->subject_content[0]->subject_name }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="p-0 m-0" id="title">
                                                            {{ $subject->subject_content[0]->updated_at->format('m/d/Y') }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    @php
                                                        $count = 0;
                                                    @endphp
                                                    @foreach ($subject->subject_notes as $a)
                                                        @if ($count++ == 2)
                                                            @if ($count == count($subject->subject_notes))
                                                                <span
                                                                    class="badge text-bg-primary">{{ $count - 2 }}+</span>
                                                            @endif
                                                        @else
                                                            <span
                                                                class="badge text-bg-primary">{{ $a->note_title }}</span>
                                                        @endif
                                                    @endforeach

                                                    @if (count($subject->subject_notes) == 0)
                                                        <span class="badge text-secondary w-100">Empty</span>
                                                    @endif

                                                </div>

                                                <div class="card-footer">
                                                    <span class="d-flex align-items-center justify-content-end">
                                                        <div>
                                                            @if (session('USER_ID') == $subject->subject_info[0]->user_id)
                                                                <i class="bi bi-person-check-fill text-primary"></i>
                                                                <strong>{{ $subject->subject_info[0]->username }}</strong>
                                                            @else
                                                                <i class="bi bi-person-fill"></i>
                                                                <strong>{{ $subject->subject_info[0]->username }}</strong>
                                                            @endif
                                                        </div>
                                                    </span>
                                                </div>

                                                <a href="{{ url('subjects/' . $subject->subject_id) }}"
                                                    class="stretched-link"></a>
                                            </div>

                                        </div>
                                    @endforeach

                                @else
                                <div class="p-3 text-center">
                                    <div
                                        class="bg-semi-dark rounded-3 border border-1 border-secondary border-opacity-25 p-4 h-100">
                                        <i class="bi bi-info-circle-fill"></i> &nbsp; No Favorite Subjects
                                    </div>

                                </div>
                                @endif

                            </div>
                        </div>

                        <div class="tab-pane fade" id="notes-tab-pane" role="tabpanel" aria-labelledby="notes-tab"
                            tabindex="0">

                            <div class="row">

                                @if (!$isNoteempty)
                                    @foreach ($likeNotes as $note)
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                            <div class="card note-card rounded-3 border border-1 border-warning border-opacity-25">
                                                <div
                                                    class="card-header border-bottom border-warning border-2 d-flex justify-content-between">
                                                    <div>
                                                        <p class="p-0 m-0 fw-bold" id="title">
                                                            {{ $note->note_content[0]->note_title }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="p-0 m-0" id="title">
                                                            {{ $note->note_content[0]->updated_at->format('m/d/Y') }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="card-body">
                                                    {{ substr(str_replace('&nbsp;', ' ', Strip_tags($note->note_content[0]->note_content)), 0, 100) . '...' }}
                                                </div>

                                                <div class="card-footer">
                                                    <span class="d-flex align-items-center justify-content-end">
                                                        <div>
                                                            @if (session('USER_ID') == $note->note_info[0]->user_id)
                                                                <i class="bi bi-person-check-fill text-warning"></i>
                                                                <strong>{{ $note->note_info[0]->username }}</strong>
                                                            @else
                                                                <i class="bi bi-person-fill"></i>
                                                                <strong>{{ $note->note_info[0]->username }}</strong>
                                                            @endif
                                                        </div>
                                                    </span>
                                                </div>

                                                <a href="subjects/{{ $note->note_content[0]->subject_id }}/{{ $note->note_id }}"
                                                    class="stretched-link"></a>

                                            </div>

                                        </div>
                                    @endforeach
                                    @else
                                    <div class="p-3 text-center">
                                        <div
                                            class="bg-semi-dark rounded-3 border border-1 border-secondary border-opacity-25 p-4 h-100">
                                            <i class="bi bi-info-circle-fill"></i> &nbsp; No Favorite Notes
                                        </div>
    
                                    </div>
                                    @endif
                            </div>


                        </div>

                        <div class="tab-pane fade" id="quizzes-tab-pane" role="tabpanel" aria-labelledby="quizzes-tab"
                            tabindex="0">

                            <div class="row">

                                @if (!$isQuizempty)
                                    @foreach ($likeQuizzes as $quiz)
                                        <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                            <div class="card note-card rounded-3 border border-1 border-info border-opacity-25">
                                                <div
                                                    class="card-header border-bottom border-info border-2 d-flex justify-content-between">
                                                    <div>
                                                        <p class="p-0 m-0 fw-bold" id="title">
                                                            {{ $quiz->quiz_content[0]->quiz_title }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="p-0 m-0" id="title">
                                                            {{ $quiz->quiz_content[0]->updated_at->format('m/d/Y') }}
                                                        </p>
                                                    </div>
                                                </div>

                                               
                                                    <div class="card-body">
                                                        <span class="fw-bold">{{ $quiz->quiz_count }} Items</span>
                                                    </div>
                                          

                                                <div class="card-footer">
                                                    <span class="d-flex align-items-center justify-content-end">
                                                  
                                                            @if (session('USER_ID') == $quiz->quiz_info[0]->user_id)
                                                                <i class="bi bi-person-check-fill text-info"></i>
                                                                <strong>{{ $quiz->quiz_info[0]->username }}</strong>
                                                            @else
                                                                <i class="bi bi-person-fill"></i>
                                                                <strong>{{ $quiz->quiz_info[0]->username }}</strong>
                                                            @endif
                                                            </button>
                                                    </span>
                                                </div>


                                                <a href="{{ url('quizzes/' . $quiz->quiz_id) }}" class="stretched-link"></a>

                                            </div>


                                        </div>
                                    @endforeach
                                    @else
                                    <div class="p-3 text-center">
                                        <div
                                            class="bg-semi-dark rounded-3 border border-1 border-secondary border-opacity-25 p-4 h-100">
                                            <i class="bi bi-info-circle-fill"></i> &nbsp; No Favorite Quizzes
                                        </div>
    
                                    </div>
                                @endif
                            </div>
                        </div>


                    </div>

                </div>
            </div>

        </div>

</div>
</main>


</div>

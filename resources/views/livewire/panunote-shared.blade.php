<div>
    <main class="">
        <div class="">
            {{-- <h1 class="h3 mb-3"><strong>Analytics</strong> Dashboard</h1> --}}
            <div class="sticky-top bg-white p-0 m-0">
                <div class="sizebox"></div>
                <div class="p-3 m-0">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link disabled fw-bold text-primary"><i class="bi bi-share-fill"></i> Shared</a>
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
                                @foreach ($sharedSubjects as $subject)
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                        <div class="card note-card rounded-3 border border-1 border-primary border-opacity-25">
                                            <div
                                                class="card-header border-bottom border-primary border-2 d-flex justify-content-between">
                                                <div>
                                                    <p class="p-0 m-0 fw-bold" id="title">
                                                        {{ $subject->subject_name }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="p-0 m-0" id="title">
                                                        {{ $subject->updated_at->format('m/d/Y') }}</p>
                                                </div>
                                            </div>


                                            <div class="card-body">
                                                @php
                                                    $count = 0;
                                                @endphp
                                                @foreach ($subject->notes as $notes)
                                                    @if ($count++ == 2)
                                                        @if ($count == count($subject->notes))
                                                            <span
                                                                class="badge text-bg-primary">{{ $count - 2 }}+</span>
                                                        @endif
                                                    @else
                                                        <span
                                                            class="badge text-bg-primary">{{ $notes->note_title }}</span>
                                                    @endif
                                                @endforeach

                                                @if (count($subject->notes) == 0)
                                                    <span class="badge text-secondary w-100">Empty</span>
                                                @endif
                                            </div>


                                            <a href="{{ url('subjects/' . $subject->subject_id) }}"
                                                class="stretched-link"></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="tab-pane fade" id="notes-tab-pane" role="tabpanel" aria-labelledby="notes-tab"
                            tabindex="0">

                            <div class="row">
                                @foreach ($sharedNotes as $note)
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                        <div class="card note-card rounded-3 border border-1 border-warning border-opacity-25">
                                            <div
                                                class="card-header border-bottom border-warning border-2 d-flex justify-content-between">
                                                <div>
                                                    <p class="p-0 m-0 fw-bold" id="title">
                                                        {{ $note->note_title }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="p-0 m-0" id="title">
                                                        {{ $note->updated_at->format('m/d/Y') }}</p>
                                                </div>
                                            </div>


                                            <div class="card-body">
                                                {{ substr(str_replace('&nbsp;', ' ', Strip_tags($note->note_content)), 0, 100) . '...' }}
                                            </div>

                                            <a href="subjects/{{ $note->subject_id }}/{{ $note->note_id }}"
                                                class="stretched-link"></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="tab-pane fade" id="quizzes-tab-pane" role="tabpanel" aria-labelledby="quizzes-tab"
                            tabindex="0">

                            <div class="row">
                          
                                @foreach ($sharedQuizzes as $quiz)
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                        <div class="card note-card rounded-3 border border-1 border-info border-opacity-25">
                                            <div
                                                class="card-header border-bottom border-info border-2 d-flex justify-content-between">
                                                <div>
                                                    <p class="p-0 m-0 fw-bold" id="title">
                                                        {{ $quiz->quiz_title }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="p-0 m-0" id="title">
                                                        {{ $quiz->updated_at->format('m/d/Y') }}</p>
                                                </div>
                                            </div>


                                            <div class="card-body">
                                                <span class="fw-bold">{{ $quiz->quiz_count }} Items</span>
                                            </div>

                                              
                                            <a href="{{ url('quizzes/'.$quiz->quiz_id) }}" class="stretched-link"></a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>


                    </div>

                </div>
            </div>

        </div>
    </main>
</div>

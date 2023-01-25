<div>
    <main class="">
        <div class="">
            <div class="bg-white p-0 m-0">
                <div class="sizebox"></div>

                <div class="px-3 my-3">
                    <div
                        class="justify-content-center align-items-center d-flex rounded-3 bg-semi-dark p-3 border border-1 border-primary">
                        <span class="text-primary px-2 fs-4 fw-bold d-flex justify-content-between w-100">
                            <div>
                                <i class="bi bi-send"></i>
                            </div>
                            <div>
                                Request List
                            </div>

                        </span>
                    </div>
                </div>

                <div class="px-3">
                    <div class="bg-semi-dark rounded-3 p-2 d-flex justify-content-between">
                        <div>
                            <input type="text" class="form-control" wire:model="search" placeholder="Search">
                        </div>

                        <div>
                            <input type="date" class="form-control" wire:model='date' placeholder="Search">
                        </div>
                    </div>
                </div>

                <div class="p-3">

                    <div class="hrdivider">
                        <hr class="text-primary">
                        <span>
                          <div class="d-flex align-items-center bg-white text-primary fs-4">
                            Subjects Access&nbsp;&nbsp;&nbsp;
                          </div>
                        </span>
                      </div>
                      
                    <div class="bg-semi-dark p-2 rounded">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Sub</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Requested</th>
                                        <th scope="col">Access</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($subject_access as $subject)
                                        <tr> 
                                            <td>{{ $subject->subject_name }}</td>
                                            <td>{{ $subject->username }}</td>
                                            <td>{{ date_format(Carbon\Carbon::parse($subject->requested_date), 'm/d h:i A') }}
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input
                                                        wire:change="subjectaccess({{ $subject->subject_access_id }})"
                                                        @if ($subject->has_access) checked @endif
                                                        class="form-check-input" type="checkbox" role="switch"
                                                        id="flexSwitchCheckChecked">
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckChecked">Access</label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="mt-3">
                        {{ $subject_access->links() }}
                    </div>

                    <div class="hrdivider mt-4">
                        <hr class="text-primary">
                        <span>
                          <div class="d-flex align-items-center bg-white text-primary fs-4">
                            Notes Access&nbsp;&nbsp;&nbsp;
                          </div>
                        </span>
                      </div>

                    <div class="bg-semi-dark p-2 rounded">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Note</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Requested</th>
                                        <th scope="col">Access</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($note_access as $note)
                                        <tr>
                                            <td>{{ $note->note_title }}</td>
                                            <td>{{ $note->username }}</td>
                                            <td>{{ date_format(Carbon\Carbon::parse($note->requested_date), 'm/d h:i A') }}
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input wire:change="noteaccess({{ $note->note_access_id }})"
                                                        @if ($note->has_access) checked @endif
                                                        class="form-check-input" type="checkbox" role="switch"
                                                        id="flexSwitchCheckChecked">
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckChecked">Access</label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="mt-3">
                        {{ $note_access->links() }}
                    </div>

                    <div class="hrdivider mt-4">
                        <hr class="text-primary">
                        <span>
                          <div class="d-flex align-items-center bg-white text-primary fs-4">
                            Quizzes Access&nbsp;&nbsp;&nbsp;
                          </div>
                        </span>
                      </div>


                    <div class="bg-semi-dark p-2 rounded">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Quiz</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Requested</th>
                                        <th scope="col">Access</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($quiz_access as $quiz)
                                        <tr>
                                            <td>{{ $quiz->quiz_title }}</td>
                                            <td>{{ $quiz->username }}</td>
                                            <td>{{ date_format(Carbon\Carbon::parse($quiz->requested_date), 'm/d h:i A') }}
                                            </td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input wire:change="quizaccess({{ $quiz->quiz_access_id }})"
                                                        @if ($quiz->has_access) checked @endif
                                                        class="form-check-input" type="checkbox" role="switch"
                                                        id="flexSwitchCheckChecked">
                                                    <label class="form-check-label"
                                                        for="flexSwitchCheckChecked">Access</label>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="mt-3">
                        {{ $quiz_access->links() }}
                    </div>

                </div>


                <div class="px-3 mb-3">
                    <div class="bg-semi-dark p-4 rounded-3  border-bottom border-5 rounded-3 border-primary">

                    </div>
                </div>


            </div>
        </div>
    </main>
</div>

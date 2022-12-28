<div>
    <main class="">
        <div class="">
            <div class="bg-white p-0 m-0">
                <div class="sizebox-test"></div>

                <div class="p-3 m-0 fixed-top bg-light border-bottom border-1 border-info">
                    <div class="d-flex justify-content-between">
                        <div class="py-1 px-2 text-info rounded fs-3">
                            Panunote |
                            <span class="fw-bold">{{ $quiz_details->quiz_title }}</span>
                        </div>

                        <div class="">
                            <span wire:loading>
                                <div id="spinner" class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                                    role="status" aria-hidden="true"></div>
                            </span>
                            @if (!empty($result))
                                <button class="btn py-1 px-2 bg-info text-light" type="button"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                    aria-controls="offcanvasRight">Results</button></button>
                                        <span class="mx-1"></span>
                            @else
                                <button wire:click="submit" class="btn py-1 px-2 bg-info text-light">Submit <i
                                        class="bi bi-check-lg"></i></button>
                            @endif

                        </div>

                    </div>
                </div>

                <div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="offcanvasRight"
                    aria-labelledby="offcanvasRightLabel">

                    <div class="offcanvas-header border-bottom border-1 border-info d-flex justify-content-between">

                        <div class="py-1 text-info rounded fs-3">
                            <span class="fw-bold">Result</span>
                        </div>

                        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                            aria-label="Close"></button>

                    </div>


                    <div class="offcanvas-body">


                        <div class="mb-3">
                            <div class="d-flex bg-info justify-content-between rounded-3 align-items-center p-3">
                                <span class="fs-1 text-light fw-bold">{{ $score }} / {{ $total }}</span>

                                <span class="fs-1 text-light">
                                    @if ($total != 0)
                                        @if (($score / $total) * 100 == 100)
                                            Perfect
                                        @elseif(($score / $total) * 100 < 100 && ($score / $total) * 100 > 50)
                                            Pass
                                        @else
                                            Failed
                                        @endif
                                    @endif
                                </span>

                            </div>
                        </div>

                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseOne" aria-expanded="false"
                                        aria-controls="flush-collapseOne">
                                        Show Answers
                                    </button>
                                </h2>
                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                    <div class="accordion-body">
                                        @if (!empty($result))

                                            @foreach ($result as $res)
                                                <div>
                                                    @if ($res['iscorrect'] == 0)
                                                        <span class="badge text-bg-primary">Correct</span>
                                                    @elseif($res['iscorrect'] == 1)
                                                        <span class="badge text-bg-danger">Wrong</span>
                                                    @else
                                                        <span class="badge text-bg-warning">No Answer</span>
                                                    @endif
                                                </div>

                                                <div class="bg-semi-dark mb-3 p-2">

                                                    <div>
                                                        @if (is_array($res['correct_answer']))
                                                            <strong>Correct Answer:</strong>
                                                            @foreach ($res['correct_answer'] as $correctans)
                                                                <span class="badge text-bg-info">
                                                                    {{ $correctans }}</span>
                                                            @endforeach
                                                        @else
                                                            <strong>Correct Answer:</strong>
                                                            <span
                                                                class="badge text-bg-info">{{ $res['correct_answer'] }}</span>
                                                        @endif
                                                    </div>

                                                </div>
                                            @endforeach

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="offcanvas-footer bg-semi-dark">
                        <div class="p-3 d-flex justify-content-end">
                            <button class="btn btn-secondary" data-bs-dismiss="offcanvas" aria-label="Close">Close</button>
                            <span class="mx-1"></span>
                            <a href="/quiz/{{$quiz_id}}" class="btn py-1 px-2 bg-info text-light" wire:click="retake">Retake</a>
                        </div>
                    </div>

                </div>

                <div class="p-2">


                    @php
                        $count_question = 1;
                    @endphp

                    @foreach ($questions as $question)
                        <div class="card mb-3 p-2 shadow-sm">
                            <div class="card-header p-2 bg-info text-white d-flex justify-content-between">
                                <div class="d-flex align-items-center fw-bold mx-2">Q{{ $count_question++ }}</div>

                                @if ($question->right_answer > 1)
                                    <div>
                                        <span class="badge text-bg-light text-info">Mutiple Answer</span>
                                    </div>
                                @endif
                            </div>

                            <div class="card-body border-bottom border-5 border-info rounded-bottom px-2 py-3 bg-light">
                                <div wire:ignore class="bg-semi-dark p-2 rounded-3">
                                    {!! $question->question_text !!}
                                </div>

                                <div class="row mt-3">


                                    @if ($question->question_type == 1)
                                        @if ($question->right_answer > 1)
                                            @php
                                                $count = 0;
                                            @endphp

                                            @foreach ($question->answers as $ans)
                                                <div class="col-3">
                                                    <div class="p-2 bg-semi-dark rounded mb-2">

                                                        <div class="form-check">
                                                            <input id="flexCheckDefault.{{ $count }}"
                                                                wire:model="useranswer.{{ $question->question_id }}.{{ $count }}"
                                                                class="form-check-input" type="checkbox"
                                                                value="{{ $ans->answer_text }}">

                                                            <label for="flexCheckDefault.{{ $count }}"
                                                                class="form-check-label" for="flexCheckDefault">
                                                                {{ $ans->answer_text }}
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                                @php
                                                    $count++;
                                                @endphp
                                            @endforeach
                                        @else
                                            @php
                                                $count = 0;
                                            @endphp

                                            @foreach ($question->answers as $ans)
                                                <div class="col-3">
                                                    <div class="p-2 bg-semi-dark rounded mb-2">

                                                        <div class="form-check">
                                                   
                                                            <input class="form-check-input" type="radio"
                                                                wire:model="useranswer.{{ $question->question_id }}"
                                                                value="{{ $ans->answer_text }}" name="useranswer.{{ $question->question_id }}"
                                                                id="flexRadioDefault.{{ $count . $question->question_id }}">

                                                            <label class="form-check-label"
                                                                for="flexRadioDefault.{{ $count . $question->question_id }}">
                                                                {{ $ans->answer_text }}
                                                            </label>

                                                        </div>

                                                    </div>
                                                </div>

                                                @php
                                                    $count++;
                                                @endphp
                                            @endforeach
                                        @endif
                                    @else
                                        <div>
                                            <textarea wire:model="useranswer.{{ $question->question_id }}" placeholder="Answer" class="form-control"
                                                cols="1" rows="1"></textarea>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <script>
                            tinymce.init({
                                menubar: false,
                                readonly: true,
                                branding: false,
                                selector: "#questionarea{{ $question['question_id'] }}",
                                plugins: "image, autoresize",
                                toolbar: "",
                                readonly: true
                            });
                        </script>

                    @endforeach
                </div>
            </div>

        </div>
    </main>
</div>

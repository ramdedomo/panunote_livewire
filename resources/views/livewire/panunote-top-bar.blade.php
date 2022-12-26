<div class="mx-2">
    <div class="mt-1 position-relative w-100" x-data="{ clicked: false }">
        <input wire:model="searchglobal" @click.outside="clicked = false" @click="clicked = true" class="form-control"
            type="text" placeholder="Search" aria-label="default input example">
        {{-- <div class="col-4"><button type="button" class="btn btn-primary search"><i class="align-middle" data-feather="search"></i></button></div> --}}

        <div x-transition x-show="clicked" class="suggest bg-white rounded-3 mt-2">

            @if($subjects->isEmpty() && $notes->isEmpty() && $quizzes->isEmpty() && empty($searchglobal))
            <div class="text-center fw-bold p-3 border border-1 border-primary border-opacity-25">
                Search <span class="text-primary">Subject,</span> <span class="text-warning">Note</span> <span class="text-info">or Quizzes</span> 
            </div>
            @elseif($subjects->isEmpty() && $notes->isEmpty() && $quizzes->isEmpty() && !empty($searchglobal))
            <div class="text-center fw-bold p-3 border border-1 border-primary border-opacity-25">
                <i class="bi bi-search"></i> Not Found
            </div>
            @else
            <div class="list-group">
                @if (!$subjects->isEmpty())
                    <div class="px-3 py-1 fw-bold text-primary border border-1 border-primary  border-opacity-25">
                        <i class="bi bi-journals"></i> Subjects
                    </div>

                    @foreach ($subjects as $subject)
                        <a href="/subjects/{{$subject->subject_id}}" class="searchglobal-item list-group-item  border-0">
                            <div class="">
                                <div class="fw-bold text-dark">{{$subject->subject_name}}</div>
                                <div class="text-muted small mt-1">
                                    Last Edited: <strong>{{date_format($subject->updated_at,"Y/m/d h:i A")}}</strong>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif

                @if (!$notes->isEmpty())
                    <div class="px-3 py-1 fw-bold text-warning border border-1 border-primary  border-opacity-25">
                        <i class="bi bi-journal"></i> Notes
                    </div>
                    @foreach ($notes as $note)
                        <a href="/subjects/{{$note->subject_id}}/{{$note->note_id}}" class="searchglobal-item list-group-item border-0">
                            <div class="">
                                <div class="fw-bold text-dark">{{$note->note_title}}</div>
                                <div class="text-muted small mt-1">          
                                    Last Edited: <strong>{{date_format($note->updated_at,"Y/m/d h:i A")}}</strong>
                                </div>
                            </div>
                        </a>
                    @endforeach
                @endif

                @if (!$quizzes->isEmpty())
                    <div class="px-3 py-1 fw-bold text-info border border-1 border-primary  border-opacity-25">
                        <i class="bi bi-question-square"></i> Quizzes
                    </div>
                    @foreach ($quizzes as $quiz)
                    <a href="/quizzes/{{$quiz->quiz_id}}" class="searchglobal-item list-group-item  border-0">
                        <div class="">
                            <div class="fw-bold text-dark">{{$quiz->quiz_title}}</div>
                            <div class="text-muted small mt-1">
                                Last Edited: <strong>{{date_format($quiz->updated_at,"Y/m/d h:i A")}}</strong>
                            </div>
                        </div>
                    </a>
                    @endforeach
                @endif






            </div>
            @endif

        </div>
    </div>
</div>

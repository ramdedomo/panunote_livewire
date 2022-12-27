<div>

    <div wire:ignore.self class="modal fade" id="sharingsettings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Share</h5>
              <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>
            <div class="modal-body">

                <div class="d-flex">
                    <div class="w-100">
                        <input id="quizsharing" wire:model.defer="urlsharing" class="form-control" type="text" disabled>
                    </div>
                    <div class="mx-2"></div>
                    <div>
                        <button onclick="quizcopytoclipboard()" class="btn btn-primary"><i class="bi bi-clipboard"></i></button>
                    </div>
                </div>
        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>


    <main class="">
        <div class="">
            <div class="bg-white p-0 m-0">
                <div class="sizebox"></div>
 
                <div class="p-3 m-0">
                    <div class="d-flex justify-content-between">
                        <div class="rounded">
                            <span class="fw-bold text-primary">{{$user_name}}</span> 
                            <span class="mx-1">|</span>
                            <a href="" class="btn py-1 px-2 text-light bg-primary">
                                <span class="d-none d-md-block">{{ $quiz_details->quiz_title }}</span>
                                <span class="d-block d-md-none"><i class="bi bi-journals"></i></span>
                            </a>
                        </div>

                        <div class="">
                            <span wire:loading>
                                <div id="spinner" class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                                    role="status" aria-hidden="true"></div>
                            </span>
                            <a href="{{route('takequiz', ['quiz_id' => $quiz_details->quiz_id])}}" target="_blank" class="btn py-1 px-2 bg-primary text-light tooltip-container">
                                Take Quiz
                                <span class="tooltip">Take a quiz</span>
                            </a>
                            <span class="">|</span>
                            <button data-bs-toggle="modal" data-bs-target="#sharingsettings" class="btn py-1 px-2 bg-primary"><i class="text-light bi bi-share"></i></button>
                            <button wire:click="like" class="btn py-1 px-2 bg-primary"> @if($isfavorite) <i class="text-light bi bi-heart-fill"></i> @else <i class="text-light bi bi-heart"></i> @endif</button>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div>
                            <input wire:model="quizname" type="text"
                                class="quizcontroller form-control fs-1 mb-2 p-0 px-2 border-1" readonly>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <span class="badge bg-info"><i class="bi bi-tag-fill"></i></span>

                                @foreach (explode (",", $quiz_details->quiz_tags ) as $tag)
                                    <a href="#" class="btn text-light badge bg-info">{{$tag}}</a>
                                @endforeach

                            </div>

                            <div>
                                
                            </div>
                        </div>
                    </div>
                </div>


                <div class="p-2">
                    @php
                        $count = 1;
                    @endphp
                    @foreach (json_decode(json_encode($questions), true) as $question)

                    <div class="card mb-3 p-2 shadow-sm">
                            <div class="card-header p-2 bg-info text-white d-flex justify-content-between">
                                <div class="fw-bold mx-2">Q{{$count++}}</div>

                                @foreach ($multiplechoices[$question['question_id']] as $choices)
                                    @php
                                        $a = $choices['answer_id'];
                                    @endphp
                                @endforeach
                            </div>

                            <div class="card-body border-bottom border-5 border-info rounded-bottom px-2 py-3 bg-light">
                                <div wire:ignore>
                                    <textarea id="questionarea{{$question['question_id']}}" wire:model="{{ 'questionsvalue.' . $question['question_id'] }}"
                                        class="form-control" cols="1" rows="1"></textarea>
                                </div>
                            </div>

                        </div>


                        <script>
                            tinymce.init({
                                height: 80,
                                menubar: false,
                                branding: false,
                                selector: "#questionarea{{ $question['question_id'] }}",
                                resize: true,
                                plugins: "image",
                                toolbar: "",
                                readonly: true
                                //toolbar: "image | fontsize | bold italic underline | undo redo",
                            });
                        </script>

                    @endforeach
                </div>
            </div>

        </div>
    </main>
</div>

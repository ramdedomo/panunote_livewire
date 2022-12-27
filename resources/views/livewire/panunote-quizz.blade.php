<div>


    <div wire:ignore.self class="modal fade" id="deleteQuiz" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Are you sure to Delete <strong>{{ $quiz_details->quiz_title }} (Quiz) </strong>?</h5>
              <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>
            <div class="modal-body">

            <div class="row gy-2 gx-2">

                <div class="col-6">
                    <div class="bg-semi-dark rounded-3 p-2">
                        <i class="bi bi-question-circle-fill text-primary"></i> <strong>{{count($questions)}}</strong> Questions
                    </div>
                </div>

                <div class="col-6">
                    <div class="bg-semi-dark rounded-3 p-2 align-items-center">
                        <i class="bi bi-heart-fill text-primary"></i> <strong>{{$quizlikes_count}}</strong> Public Likes 
                    </div>
                </div>
                
                <div class="col-6">
                    <div class="bg-semi-dark rounded-3 p-2">
                        <i class="bi bi-pen-fill text-primary"></i> <strong>{{$quiztakes_count}}</strong> Public Takes
                    </div>
                </div>

                <div class="col-6">
                    <div class="bg-semi-dark rounded-3 p-2">
                        <i class="bi bi-door-open-fill text-primary"></i> <strong>{{$quizvisits_count}}</strong> Public Visits
                    </div>
                </div>

                <div>
                    <hr class="m-0">
                </div>

                <div>
                    <div class="form-check form-switch d-flex justify-content-center">
                        <input class="form-check-input" role="switch" type="checkbox" wire:model="preserveroom" id="preserveroom" data-onstyle="primary">
                        <span class="mx-1"></span>
                        <label class="form-check-label" for="preserveroom">Preserve Gamification History (if any)</label>
                    </div>
                </div>

            </div>
        
            </div>

            <div class="modal-footer">
                <button data-bs-dismiss="modal" aria-label="Close" type="button" class="btn bg-secondary text-light">Cancel</button>
                <button wire:click="delete" data-bs-dismiss="modal" aria-label="Close" type="button" class="btn bg-warning text-light">Delete</button>
            </div>
          </div>
        </div>
      </div>

    
    <div wire:ignore.self class="modal fade" id="editTag" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel"><strong>{{ $quiz_details->quiz_title }}</strong> Tags</h5>
              <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>
            <div class="modal-body">

              <div class="">
                    <div class="bg-semi-dark p-2 rounded text-secondary text-center mb-2">
                        <i class="bi bi-info-circle"></i> Seperate Tags using <strong>","</strong> &nbsp;&nbsp; / &nbsp;&nbsp;  <strong>Example: Panunote,Panugame</strong> 
                    </div>
                    <div class="form-floating">
                        <textarea wire:model.defer="quiztags" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                        <label for="floatingTextarea2">Tags</label>
                    </div>
            </div>
            
        
            </div>

            <div class="modal-footer">
                <button wire:click="updateTag" data-bs-dismiss="modal" aria-label="Close" type="button" class="btn btn-primary">Update</button>
            </div>
          </div>
        </div>
      </div>
      


    <div wire:ignore.self class="modal fade" id="sharingsettings" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Sharing Settings</h5>
              <a type="button" class="btn-link" data-bs-dismiss="modal" aria-label="Close">Close</a>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-6">
                        Sharing:
                    </div>

                    <div class="col-6">
                        URL:
                    </div>
                </div>
              
                <div class="row">
                    <div class="col-6">
                        <select wire:change="sharingsetting" wire:model="sharing" class="form-select">
                            <option value="true">On</option>
                            <option value="false">Off</option>
                          </select>
                    </div>

                    <div class="col-6">
                        <input wire:model.defer="urlsharing" class="form-control" type="text" disabled>
                    </div>
                </div>
        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Done</button>
            </div>
          </div>
        </div>
      </div>


    <main class="" >
        <div class="">
            <div class="bg-white p-0 m-0 border-bottom border-2 border-primary">
                <div class="sizebox"></div>

                {{-- <div class="toast-container position-fixed end-0 p-3">
                    <div id="savedToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                      <div class="toast-header bg-primary text-light">
                        <strong class="me-auto">Panunote</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                      </div>
                      <div class="toast-body bg-light text-dark">
                        Saved
                      </div>
                    </div>
                </div> --}}

                <div class="toast-container position-fixed end-0 p-3">
                    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                      <div class="toast-header bg-primary text-light">
                        <strong class="me-auto">Panunote</strong>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                      </div>
                      <div class="toast-body bg-light text-dark">
                        Something went wrong, please try again or refresh the page.
                      </div>
                    </div>
                </div>

                <div class="p-3 m-0">
                    <div class="d-flex justify-content-between">
                        <div class="">
                            <a href="{{ url('quizzes/') }}" class="btn py-1 text-light bg-primary"><i
                                    class="bi bi-question-square"></i> Quizzes</a>

                            <span>|</span>
                            {{-- <span class="mx-2">|</span> --}}
                            <a href="" class="disabled btn py-1 px-2 text-light bg-primary">
                                <span class="d-none d-md-block">{{ $quiz_details->quiz_title }}</span>
                                <span class="d-block d-md-none"><i class="bi bi-journals"></i></span>
                            </a>
                        </div>

                        <div class="">
                            <span wire:loading>
                                <div id="spinner" class="spinner-grow spinner-grow-sm justify-content-center p-0 m-0"
                                    role="status" aria-hidden="true"></div>
                            </span>
                            <button wire:click="savechanges" class="text-light btn py-1 px-2 bg-primary"><i
                                    class="bi bi-file-earmark-check"></i> Save</button>
                            <span>|</span>

                            <a href="{{route('takequiz', ['quiz_id' => $quiz_details->quiz_id])}}" target="_blank" class="btn py-1 px-2 bg-primary text-light tooltip-container">
                                Take Quiz
                                <span class="tooltip">Take a quiz</span>
                            </a>

                            <button data-bs-toggle="modal" data-bs-target="#sharingsettings" class="text-light btn py-1 px-2 bg-primary"><i class="bi bi-share"></i> Share</button>
                            <button wire:click="like" class="btn py-1 px-2 bg-primary"> @if($isfavorite) <i class="text-light bi bi-heart-fill"></i> @else <i class="text-light bi bi-heart"></i> @endif</button>
                            <span>|</span>
                            <button data-bs-toggle="modal" data-bs-target="#deleteQuiz" class="btn py-1 px-2 bg-warning"><i class="text-light bi bi-journal-x"></i></button>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div>
                            <input wire:model="quizname" type="text"
                                class="quizcontroller form-control fs-1 mb-2 p-0 px-2 border-1">
                        </div>

                        <div class="d-flex justify-content-between">

                            <div>
                                <span class="badge bg-info"><i class="bi bi-tag-fill"></i></span>
                                @foreach (explode (",", $quiz_details->quiz_tags ) as $tag)
                                <a href="#" class="btn text-light badge bg-info">{{$tag}}</a>
                            @endforeach
                            <span  data-bs-toggle="modal" data-bs-target="#editTag" class="btn text-info badge border-1 border-info"><i class="bi bi-pencil-fill"></i> Edit</span>
                            </div>

                            <div>
                                @if($saved)
                                <span class="saved badge bg-primary">
                                    Saved 
                                    @php
                                        echo Carbon\Carbon::now('Asia/Manila')->format('h:i:s');
                                    @endphp
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div class="p-2">

                    {{-- <div class="d-flex justify-content-between m-2">
                        <div class="bg-semi-dark w-100 rounded"></div>
                        <div class="mx-1"></div>
                        <div><button wire:click="create" class="btn rounded btn-primary px-2"><i class="bi bi-plus-circle"></i></button></div>
                    </div> --}}
                    @php
                        $count = 1;
                    @endphp

                    @foreach (json_decode(json_encode($questions), true) as $question)
                        <div class="card mb-3 p-2 shadow-sm">

                            <div class="card-header p-2 bg-info text-white d-flex justify-content-between">
                                <div class="d-flex align-items-center fw-bold mx-2">Q{{$count++}}</div>

                                @foreach ($multiplechoices[$question['question_id']] as $choices)
                                    @php
                                        $a = $choices['answer_id'];
                                    @endphp
                                @endforeach

                                <div class="d-flex">
                                    <div>
                                        <select wire:model="{{ 'questiontype.' . $question['question_id'] }}"
                                            wire:change="quiztypechanged({{ $question['question_id'] }},{{$a}})"
                                            class="form-select form-select-sm rounded-2">
                                            <option value="1">Multiple</option>
                                            <option value="2">Identification</option>
                                        </select>
                                    </div>

                                    <div class="mx-1"></div>

                                    <div>
                                        <select wire:model="{{ 'questiondifficulty.' . $question['question_id'] }}"
                                            class="form-select form-select-sm rounded-2">
                                            <option value="1">Easy</option>
                                            <option value="2">Intermediate</option>
                                            <option value="3">Hard</option>
                                        </select>
                                    </div>

                                    <div class="mx-1"></div>

                                    <div>
                           
                                        <button
                                            wire:click="deletequestion({{ $question['question_id'] }})"
                                            class="btn btn-sm bg-warning text-light px-2 tooltip-container"><i
                                                class="bi bi-trash3"></i>
                                                <span class="tooltip-delete">Warning: Automatically save all the changes and delete this Item</span></button>
                                    </div>



                                </div>
                            </div>

                            <div class="card-body border-bottom border-5 border-info rounded-bottom px-2 py-3 bg-light">
                                <div wire:ignore wire:key="question-{{ $question['question_id'] }}">
                                    <textarea id="questionarea{{ $question['question_id'] }}" wire:model="{{ 'questionsvalue.' . $question['question_id'] }}" cols="1" rows="1"></textarea>
                                </div>

                                {{-- multiple choice --}}
                                @if ($question['question_type'] == 1)
                                    @if ($questiontype[$question['question_id']] == '1')
                                        <div>
                                            <div class="d-flex mt-3">

                                                <div class="mx-2">A:</div>
                                                <div class="mx-1"></div>
                                                <div class="w-100">

                                                    @foreach ($multiplechoices[$question['question_id']] as $choices)
                                                        @if ($show[$choices['answer_id']])
                                                            @php
                                                                $choices = json_decode(json_encode($choices), true);
                                                            @endphp

                                                            <div class="form-check">
                                                                <input
                                                                    name="multiplerightanswer{{ $choices['answer_id'] }}"
                                                                    id="multiplerightanswer{{ $choices['answer_id'] }}"
                                                                    wire:model="multiplerightanswer.{{ $choices['answer_id'] }}"
                                                                    value="{{ $choices['answer_text'] }}"
                                                                    class="form-check-input" type="checkbox">

                                                                <div class="d-flex justify-content-between mb-1">

                                                                    <div class="w-100">
                                                                        <textarea wire:model="answer.{{ $choices['answer_id'] }}" class="form-control" cols="1" rows="1"></textarea>
                                                                    </div>
                                                                    
                                                                    
                                                                    @if ($choices['answer_id'] != $publicid[$question['question_id']])
                                                                        <div class="mx-1"></div>

                                                                        <div>

                                                                            <button
                                                                                wire:click="deletechoice('{{ $choices['answer_id'] }}','{{ $question['question_id'] }}')"
                                                                                class="btn bg-semi-dark text-secondary px-2"><i
                                                                                    class="bi bi-x"></i></button>
                                                                        </div>
                                                                    @endif

                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                    <div class="d-flex mt-2">
                                                        <div class="w-100">
                                                            <textarea wire:model="addchoicefield.{{ $question['question_id'] }}" class="form-control" cols="1"
                                                                rows="1"></textarea>
                                                        </div>
                                                        <div class="mx-1"></div>
                                                        <div>
                                                            <button
                                                                wire:click="addchoicenew({{ $question['question_id'] }})"
                                                                class="btn btn-primary px-2"><i
                                                                    class="bi bi-plus"></i></button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @elseif($questiontype[$question['question_id']] == '2')
                                        <div>
                                            <div class="d-flex mt-3">
                                                <div class="mx-2">A:</div>
                                                <div class="mx-1"></div>
                                                <div class="w-100">

                                                    <textarea wire:model="identification.{{ $a }}" class="form-control" id="" cols="1"
                                                        rows="1"></textarea>

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @elseif($question['question_type'] == 2)


                                    @if ($questiontype[$question['question_id']] == '2')

                                        <div>
                                            <div class="d-flex mt-3">
                                                <div class="mx-2">A:</div>
                                                <div class="mx-1"></div>
                                                <div class="w-100">

                                                    <textarea wire:model="identification.{{ $a }}" class="form-control" id="" cols="1"
                                                        rows="1"></textarea>

                                                </div>
                                            </div>
                                        </div>

                                    @elseif($questiontype[$question['question_id']] == '1')
                                        <div>
                                            <div class="d-flex mt-3">
                                                <div class="mx-2">A:</div>
                                                <div class="mx-1"></div>
                                                <div class="w-100">

                                                    @foreach ($multiplechoices[$question['question_id']] as $choices)
                                                     @php
                                                        $choices = json_decode(json_encode($choices), true);
                                                     @endphp
                                                        @if ($show[$choices['answer_id']])
                                                            <div class="form-check">
                                                                <input
                                                                    name="multiplerightanswer{{ $choices['answer_id'] }}"
                                                                    id="multiplerightanswer{{ $choices['answer_id'] }}"
                                                                    wire:model="multiplerightanswer.{{ $choices['answer_id'] }}"
                                                                    value="{{ $choices['answer_text'] }}"
                                                                    class="form-check-input" type="checkbox">

                                                                <div class="d-flex justify-content-between mb-1">
                                                                    
                                                                    <div class="w-100">
                                                                        <textarea wire:model="answer.{{ $choices['answer_id'] }}" class="form-control" cols="1" rows="1"></textarea>
                                                                    </div>


                                                                    @if ($choices['answer_id'] != $publicid[$question['question_id']])
                                                                        <div class="mx-1"></div>

                                                                        <div>

                                                                            <button
                                                                                wire:click="deletechoice('{{ $choices['answer_id'] }}','{{ $question['question_id'] }}')"
                                                                                class="btn bg-semi-dark text-secondary px-2"><i
                                                                                    class="bi bi-x"></i></button>
                                                                        </div>
                                                                    @endif


                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach


                                                    <div class="d-flex mt-2">
                                                        <div class="w-100">
                                                            <textarea wire:model="addchoicefield.{{ $question['question_id'] }}" class="form-control" cols="1"
                                                                rows="1"></textarea>
                                                        </div>
                                                        <div class="mx-1"></div>
                                                        <div>
                                                            <button
                                                                wire:click="addchoicenew({{ $question['question_id'] }})"
                                                                class="btn btn-primary px-2"><i
                                                                    class="bi bi-plus"></i></button>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

                
                        <script>
                        tinymce.init({
                                height: 150,
                                menubar: false,
                                branding: false,
                                selector: "#questionarea{{ $question['question_id'] }}",
                                resize: true,
                                plugins: "image",
                                //toolbar: "image | alignleft aligncenter alignright",
                                toolbar: "image",
                                setup: function(ed) {
                                    ed.on('Change', function(e) {
                                        @this.set("questionsvalue.{{ $question['question_id'] }}", ed.getContent());
                                    });

                                    ed.addShortcut('ctrl+S', 'Save', () => {
                                        window.livewire.emit('set:savechanges');
                                    });
                                },

                                
                            });
                        </script>
                    @endforeach


                    {{-- <div class="d-flex justify-content-between m-2">
                        <div class="bg-semi-dark w-100 rounded"></div>
                        <div class="mx-1"></div>
                        <div><button data-bs-toggle="modal" data-bs-target="#addquestion" class="btn rounded btn-primary px-2"><i class="bi bi-plus-circle"></i></button></div>
                    </div> --}}

                    <div class="d-flex justify-content-between m-2">
                        <div class="bg-semi-dark rounded flex-grow-1"></div>
                        <div class="mx-1"></div>
                        <div><button wire:click="create" class="btn rounded btn-primary px-2"><i class="bi bi-plus-circle"></i> Question</button></div>
                    </div>
                </div>
         

            <script>
                document.addEventListener('livewire:load', function () {
                    window.addEventListener('deleted', event => {
                    });
                })
        
                document.addEventListener('keydown', (e) => {
                    if (e.ctrlKey && String.fromCharCode(e.keyCode).toLowerCase() === 's') {
                        e.preventDefault();
                        e.stopPropagation();
                        window.livewire.emit('set:savechanges');
                    }
                }, false);
            </script>

        </div>
    </main>
</div>

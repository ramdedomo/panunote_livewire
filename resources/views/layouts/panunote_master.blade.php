<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    @vite(['resources/js/app.js'])
    <link rel="shortcut icon" href="{{ asset('img/favicon_main.ico') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src='https://unpkg.com/tesseract.js@2.1.0/dist/tesseract.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1"></script>
    <script src="https://cdn.tiny.cloud/1/wfuqkmql36bw2zkf9fqzskn8lk2yue6yyk7tak3n60qoexkt/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @livewireStyles





</head>

<body style="overflow-y: auto">


    <div class="toast-container position-fixed end-0 p-3" wire:ignore>
        <div id="liveToast" class="toast" data-bs-delay="2000" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-primary text-light">
                <strong class="me-auto">Panunote</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
            <div class="toast-body bg-light text-dark">
                <span class="content-toast">

                </span>
            </div>
            <div>
            </div>
        </div>
    </div>

    <div class="wrapper">
        <x-panunote_sidebar />
        <div class="main">
            <x-panunote_topbar image="{{ $name->user_photo }}" username="{{ $name->user_fname . ' ' . $name->user_lname }}" />
            {{-- @yield('content') use this if you don't use livewire --}}
            {{ $slot }}
            {{-- <x-panunote_footer/> --}}
        </div>

    </div>


    @livewireScripts
    <script src="{{ asset('js/app2.js') }}"></script>
    <script>
        $("#getvalue").click(function() {
            console.log(tinymce.get("mytextarea").getContent());
            //console.log(tinyMCE.activeEditor.getContent({format : 'text'}));
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

    <script>

        window.addEventListener('emptyanswer', event => {
            $(".content-toast").text('No Answers Found. To Generate Question highlight possible answer in the note below.');
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });

        window.addEventListener('limitparaerror', event => {
            $(".content-toast").text('You can only Paraphrase 100 Characters (for now)');
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });
        

        window.addEventListener('limiterror', event => {
            $(".content-toast").text('You can only Generate 5 Questions (for now), Reduce your highlighted answers');
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });
        

        window.addEventListener('modified', event => {
            $(".content-toast").text('Personal Info Updated!');
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });

        window.addEventListener('notesaved', event => {
            $(".content-toast").text('Note Saved!');
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });

        window.addEventListener('quizsaved', event => {
            $(".content-toast").text('Quiz Saved!');
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });

        window.addEventListener('savedNote', event => {
            $(".content-toast").text('Saved!');
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });

        window.addEventListener('SubjectRequired', event => {
            $(".content-toast").text('Subject Name is Required!');
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });

        window.addEventListener('SelectRequired', event => {
            $(".content-toast").text('Select Subject is Required!');
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });

        window.addEventListener('validation_empty', event => {
            $(".content-toast").text('Quiz Title and Sharing is Required!');
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });

        window.addEventListener('validation', event => {
            $(".content-toast").text('All fields are Required!');
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });

        window.addEventListener('error', event => {
            $(".content-toast").text('Something went wrong, please try again or reload the page');
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });

        window.addEventListener('paraphrased', event => {
            $('#staticBackdrop').modal('show');
        })

        window.addEventListener('generated', event => {
            $('#staticBackdrop_generated').modal('show');
        })

        window.addEventListener('createdsubject', event => {
            $('#staticBackdrop').modal('hide');
        })

        window.addEventListener('deleted', event => {
            $('#deleteNote').modal('hide');
            $('#deleteQuiz').modal('hide');
            $('#deleteSubject').modal('hide');
        })

        window.addEventListener('createdquiz', event => {
            $('#staticBackdrop').modal('hide');
        })

        window.addEventListener('creatednote', event => {
            $('#staticBackdrop').modal('hide');
        })

        window.addEventListener('error', event => {
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        })

        window.addEventListener('saved', event => {
            const toast = new bootstrap.Toast($('#savedToast'));
            toast.show();
        })

        function copytoclipboard() {
            navigator.clipboard.writeText($("#paraphrasedtext").val());
            $('#staticBackdrop').modal('hide');
        }

        function quizcopytoclipboard() {
            navigator.clipboard.writeText($("#quizsharing").val());
        }

        function notecopytoclipboard() {
            navigator.clipboard.writeText($("#notesharing").val());
        }

        function subjectcopytoclipboard() {
            navigator.clipboard.writeText($("#subjectsharing").val());
        }



        //$('.filter').selectpicker('mobile');


        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
            $('.filter').selectpicker('mobile');
        }


        // window.addEventListener('contentChanged', event => {
            
        //     $(".owl-carousel").owlCarousel({
        //         loop: false,
        //         margin: 10,
        //         nav: false,
        //         dots: false,
        //         margin: 10,
        //         pagination: false,
    
        //         responsive: {
        //             0: {
        //                 items: 1
        //             },
        //             600: {
        //                 items: 2
        //             },
        //             1000: {
        //                 items: 3
        //             }
        //         }
        //     });
        // });
            
        $(".owl-carousel").owlCarousel({
            loop: false,
            margin: 10,
            nav: false,
            dots: false,
            margin: 10,
            pagination: false,

            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });

   
    </script>

</body>




</html>

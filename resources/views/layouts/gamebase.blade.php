@if(Auth::user()->isverified == 0)
    <script>window.location = "/verify";</script>
@endif


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Panugame</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @vite(['resources/js/app.js'])

    <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}">
    <script src="https://cdn.tiny.cloud/1/wfuqkmql36bw2zkf9fqzskn8lk2yue6yyk7tak3n60qoexkt/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"
        integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

<body style="overflow-y: auto; background-image:url({{ url('img/logos/panunote_bg2.png') }}); background-size: cover;">

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


    <div>
        {{ $slot }}
    </div>

    @livewireScripts
    <script src="{{ asset('js/app2.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/i18n/defaults-*.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="{{ asset('js/timeme.js') }}"></script>

    <script>
        TimeMe.initialize({
            currentPageName: "game", // current page
            idleTimeoutInSeconds: 5 // seconds
        });

        window.onload = function() {
            setInterval(function() {
                var timeSpentOnPage = TimeMe.getTimeOnCurrentPageInSeconds();
			    //document.getElementById('timeInSeconds').textContent = timeSpentOnPage.toFixed(2);
            }, 25);
        }
        //kick

        //$('.filter').selectpicker('mobile');
        window.addEventListener('kicked', event => {
            $(".content-toast").text("You have been kicked by the admin! Redirecting...");
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });

        window.addEventListener('wrongcredentials', event => {
            $(".content-toast").text("Wrong Credentials Please Try Again");
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });


        window.addEventListener('notify', event => {
            $(".content-toast").text("Your are now the admin!");
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        });

        window.addEventListener('error', event => {
            $(".content-toast").text("Something went wrong, please try again or refresh the page.");
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        })

        window.addEventListener('playerjoined', event => {
            $(".content-toast").text(event.detail.player_name + " joined the game!");
            const toast = new bootstrap.Toast($('#liveToast'));
            toast.show();
        })


        if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {
            $('.lobbyfilter').selectpicker('mobile');
        }
    </script>



</body>

</html>

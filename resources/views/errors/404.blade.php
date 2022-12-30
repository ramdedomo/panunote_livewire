<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 - Panunote</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="vh-100 vw-100 d-flex justify-content-center align-items-center">
        <div>
            It could be Page not found or you Leaved the game :)
            <br>

            <div class="d-flex justify-content-center align-items-center mt-3">
                <a href="{{route('panugame')}}">To Panugame</a>
                <span class="mx-2"></span>
                <a href="{{route('/')}}">To Home</a>
            </div>
        </div>
    


    </div>
</body>
</html>


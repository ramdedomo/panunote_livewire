<style>
    .font{
       font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        color: #17a2b8;
    }

    .button-reset{
        text-decoration: none;
        padding: 10px;
        width: 390px;
        border: 0;
        background-color: rgb( 230, 92, 79);
        color: white;
        font-size: 20px;
        font-weight: bold;
        border-radius: 5px;
    }

    .button-reset:hover{
        cursor: pointer;
        background-color: rgb(237, 115, 104);
    }

    .image{
        border-radius: 5px;
    }
</style>

<div class="image" style="overflow-y: auto;  width: 390px; height:100px; background-image:url({{ url('img/logos/panugame_element3.png') }}); background-size: cover;">

</div>

<h1 class="font color">{{$title}}</h1>
<h3 class="font">Hi {{$name}}!,</h3>
<p class="font">{{$info}}</p>
<div style="width: 390px;  display: flex; text-align: center;">
{!! $body !!}

</div>


<div class="font" style="font-size:10px; width: 390px; margin-top: 30px; text-align:center;">
    <strong>Panunote: Online Study Companion</strong>  {{Carbon\Carbon::now()->year}}
</div>

<div class="image" style="margin-top: 30px; overflow-y: auto;  width: 390px; height:50px; background-image:url({{ url('img/logos/panugame_element2.png') }}); background-size: cover;">

</div>
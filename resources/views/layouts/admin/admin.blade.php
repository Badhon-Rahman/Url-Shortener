<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Url_Shortener_Admin') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="bg-gray-100">
            @include('layouts.admin.admin-navigation')
            <br>
            <div class="row accesUrl">
                <div class="input-group">
                    <input id="accessUrl" class="form-control center-block" type="text" name="url" value="" placeholder="Pest or Enter your shortern link to access original link" required autofocus />
                    <button class="CButton">
                        {{ __('Access Link') }}
                    </button>
                </div>
                <div class="col">
                    
                </div>
            </div>
            <br>
        </div>
    </body>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    const basePath = window.location.origin;

    $(".CButton").click(function(){
        let accessLink = $("#accessUrl").val();
        
        if(accessLink != ''){
            $.ajax({
                url :  basePath + '/access-link',
                type : 'GET',
                data : {
                    'shorternUrl' : accessLink
                },
                dataType:'json',
                success : function(data) {  
                    if(data != ''){
                        window.open( data[0].original_url, '_blank');
                    }
                    else{
                        alert('This Shortern link has been expired.');
                    }    
                },
                error : function(request,error)
                {
                    alert('Url access request can not proceed');
                }
            });
        }
        else{
            alert("Please enter the shortern url To access that link.");
        }
    });
</script>
</html>
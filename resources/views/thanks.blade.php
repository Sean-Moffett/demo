<!DOCTYPE html>
<html>
    <head>
        <title>Phone2Action - Petition Signed - Thanks</title>
        <link href="{{ asset('css/phone2action.css') }}" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <br><br>
        <div>
            <img class="div-p2a-login-logo" src="{{ asset('images/p2a-logo.png') }}">

            <div class="dashboard-title u-center">Petition Signature Confirmation</div>
            
            {!! csrf_field() !!}

            <div class="petition-thanks-container">
                <div class="petition-thanks-msg">
                    {{$petition->thanks_msg}}
                </div>
            </div>
            <br><br>
            <a href="/dashboard/"><button type="button">Ok</button></a>
        </div>
    </body>
</html>

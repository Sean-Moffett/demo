<!DOCTYPE html>
<html>
    <head>
        <title>Phone2Action - Login</title>
        <link href="{{ asset('css/phone2action.css') }}" rel="stylesheet" type="text/css" >
    </head>
    <body>

        <form method="POST" action="/login">
            {!! csrf_field() !!}
            <div class="login-form u-center-form ">

                <div>
                    <img class="div-p2a-login-logo" src="{{ asset('images/p2a-logo.png') }}">
                </div>
                <div class="form-title">Login:</div>
                <div>
                    <label>Email Address:</label>
                    <div><input type="text" name="email"></div>
                </div>
                <div>
                    <label>Password:</label>
                    <div><input type="password" name="password"></div>
                </div>
                <div>
                    <div class="button-container">
                        <button type="submit">Login</button>
                    </div>
                    <div class="u-center">
                        <a href="/register">New User? Click here to register</a>
                    </div>
                </div>
                @include('form-errors')
            </div>
        </form>
    </body>
</html>

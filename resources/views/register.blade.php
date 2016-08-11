<!DOCTYPE html>
<html>
    <head>
        <title>Phone2Action - Register</title>
        <link href="{{ asset('css/phone2action.css') }}" rel="stylesheet" type="text/css" >
    </head>
    <body>

        <form method="POST" action="/register">
            {!! csrf_field() !!}
             <div class="registration-form u-center-form ">
                <div>
                    <img class="div-p2a-login-logo" src="{{ asset('images/p2a-logo.png') }}">
                </div>
                <div class="form-title">Register:</div>
                <div>
                    <label>First Name:</label>
                    <div><input type="text" name="first_name" value="{{old('first_name')}}"></div>
                </div>
                <div>
                    <label>Last Name:</label>
                    <div><input type="text" name="last_name" value="{{old('last_name')}}"></div>
                </div>
                <div>
                    <label>Email Address:</label>
                    <div><input type="text" name="email" value="{{old('email')}}"></div>
                </div>
                <div>
                    <label>Password:</label>
                    <div><input type="password" name="password"></div>
                </div>
                <div>
                    <div class="button-container">
                        <button type="submit">Register</button>
                    </div>
                    <div class="u-center">
                        <a href="/login">Already a User? Click here to login</a>
                    </div>
                </div>
                @include('form-errors')
            </div>
        </form>
    </body>
</html>

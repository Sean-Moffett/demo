<!DOCTYPE html>
<html>
    <head>
        <title>Phone2Action - Sign Petition</title>
        <link href="{{ asset('css/phone2action.css') }}" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <br><br>
        <div>


            <img class="div-p2a-login-logo" src="{{ asset('images/p2a-logo.png') }}">

            <div class="dashboard-title u-center">Sign Petition</div>
            
            <form method="POST">
                {!! csrf_field() !!}
                <div class="sign-petition-container">

                    <div class="sign-petition-content">

                        <img src="/{{$petition->picture_path}}" >
                        <br>

                        Recipient: {{$petition->recipient_name}}<br><br>
                        Recipient Email: {{$petition->recipient_email}}<br><br>
                        Title:{{$petition->title}}<br><br>
                        Summary:<br>{{$petition->summary}}<br><br>
                        Body:<br>{{$petition->body}}<br><br>
                        <br><br>
                        <label>Type your name to sign:</label>
                        <input type="text" name="signature">
                        <label>Phone:</label>
                        <input type="text" name="phone">
                        <div class="u-center">
                            <div class="button-container">
                                <button type="submit">Sign Petition</button>
                                <a href="/dashboard/"><button type="button">Cancel</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                @include('form-errors')
            </form>
        </div>
    </body>
</html>

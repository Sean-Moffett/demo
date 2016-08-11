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
                   
                </div>
            </div>
            <br><br>

            <div class="dashboard-title u-center">Petition Details</div>

            <div class="petition-thanks-container">
                <div class="petition-thanks-msg">

                    <div class="sign-petition-container">

                        <div class="sign-petition-content">

                            <img src="/{{$petition->picture_path}}" >
                            <br>

                            <div class="sign-petition-content-block-header">
                                Petition Recipient: 
                            </div>
                            <div class="sign-petition-content-block">
                                {{$petition->recipient_name}} ({{$petition->recipient_email}})<br><br>
                            </div>

                            <div class="sign-petition-content-block-header">
                                 Title: 
                            </div>
                            <div class="sign-petition-content-block">
                                {{$petition->title}}<br><br>
                            </div>

                            <div class="sign-petition-content-block-header">
                                Summary: 
                            </div>
                            <div class="sign-petition-content-block">
                                {{$petition->summary}}<br><br>
                            </div>

                            <div class="sign-petition-content-block-header">
                                Body: 
                            </div>
                            <div class="sign-petition-content-block">
                                {{$petition->body}}<br><br>
                            </div>
                        </div>

                    </div>
                    <br><br>

                    <div class="dashboard-title u-center">Petition Signatures</div>
                    <table>
                        <tr>
                            <th>Signature</th>
                            <th>Date</th>
                        </tr>
                        @foreach($signatures as $signature)
                            <tr>
                                <td>
                                    {{$signature->signature}}
                                </td>
                                <td>
                                    {{$signature->created_at}}
                                </td>
                            </tr>

                        @endforeach
                    </table>
                    <br><br>

                    <a href="/dashboard/"><button type="button">Ok</button></a>
                </div>
            </div>

        </div>
    </body>
</html>

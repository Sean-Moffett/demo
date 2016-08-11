<!DOCTYPE html>
<html>
    <head>
        <title>Phone2Action - Dashboard</title>
        <link href="{{ asset('css/phone2action.css') }}" rel="stylesheet" type="text/css" >
    </head>
    <body>
        <br><br>
        <div>
            <img class="div-p2a-login-logo" src="{{ asset('images/p2a-logo.png') }}">

            <div class="dashboard-title u-center">Petition Dashboard</div>
            
            <div class="button-container">
                <a href="/petition/edit"><button type="button">Create a New Petition</button></a>
                <a href="/logout"><button type="button">Logout</button></a>
            </div>

            <br><br><br>
            @include('form-errors')
            <br><br>

            <div class="dashboard-title u-center">Your Petitions:</div>
            <br>
            <table class="data-table"> 
                <tr>
                    <th>Petition Title</th>
                    <th>Petition Date</th>
                    <th>Published</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Sign</th>
                    <th>Signature Count</th>
                </tr>
                @foreach($auth_user_petitions as $user_petition)
                    <tr>
                        <td>{{$user_petition->title}}</td>
                        <td>{{$user_petition->created_at}}</td>
                        <td>@if($user_petition->private)Private @else Public @endif</td>
                        <td><a href="/petition/view/{{$user_petition->id}}">View</a></td>
                        <td><a href="/petition/edit/{{$user_petition->id}}">Edit</a></td>
                        <td><a href="/petition/sign/{{$user_petition->id}}">Sign</a></td>
                        <td>{{$user_petition->signature_count}}</td>
                    </tr>
                @endforeach
            </table>


            <br><br><br>

            <div class="dashboard-title u-center">Other Public Petitions:</div>
            <br>
            <table class="data-table"> 
                <tr>
                    <th>Petition Title</th>
                    <th>Petition Date</th>
                    <th>Published</th>
                    <th>View</th>
                    <th>Edit</th>
                    <th>Sign</th>
                    <th>Signature Count</th>
                </tr>

                @foreach($other_petitions as $user_petition)
                    <tr>
                        <td>{{$user_petition->title}}</td>
                        <td>{{$user_petition->created_at}}</td>
                        <td>@if($user_petition->private)Private @else Public @endif</td>
                        <td><a href="/petition/view/{{$user_petition->id}}">View</a></td>
                        <td><a href="/petition/edit/{{$user_petition->id}}">Edit</a></td>
                        <td><a href="/petition/sign/{{$user_petition->id}}">Sign</a></td>
                        <td>{{$user_petition->signature_count}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </body>
</html>

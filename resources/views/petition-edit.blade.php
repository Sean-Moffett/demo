<!DOCTYPE html>
<html>
    <head>
        <title>Phone2Action - Petition</title>
        <link href="{{ asset('css/phone2action.css') }}" rel="stylesheet" type="text/css" >
    </head>
    <body>

        {{ Form::model($petition,['files'=>true]) }}
            {!! csrf_field() !!}
            <div class="dashboard-form-container u-center">
                 <div class="dashboard-form">
                    <div>
                        <div class="form-title">@if($petition) Edit @else Create @endif Petition:</div>
                        <div>
                            <label>Petition Target Recipient Name:</label>
                            <div>{{Form::text('recipient_name')}}</div>
                        </div>
                        <div>
                            <label>Petition Target Recipient Email:</label>
                            <div>{{Form::text('recipient_email')}}</div>
                        </div>
                        <div>
                            <label>Petition Title</label>
                            <div>{{Form::text('title')}}</div>
                        </div>
                         <div>
                            <label>Petition Summary:</label>
                            <div>{{Form::textarea('summary')}}</div>
                        </div>
                        <div>
                            <label>Petition Body:</label>
                            <div>{{Form::textarea('body')}}</div>
                        </div>
                        <div>
                            <label>Custom Thanks Message:</label>
                            <div>{{Form::textarea('thanks_msg')}}</div>
                        </div>
                        <div>
                            <label>Petition Image:</label>
                            <div>{{ Form::file('image')}}</div>
                        </div>
                        <div>
                            <div>
                                <br><br>
                                <input type="checkbox" name="private" @if($petition && $petition->private) checked @endif>Petition is private?
                            </div>
                        </div>
                        <div class="button-container">
                            <button type="submit">Save Petition</button>
                            @if($petition)
                                <a href="/petition/delete/{{$petition->id}}"><button type="button">Delete</button></a>
                            @endif 
                            <a href="/dashboard/"><button type="button">Cancel</button></a>
                        </div>
                    </div>
                    @include('form-errors')
                </div>
            </div>
        {{ Form::close() }}
    </body>
</html>

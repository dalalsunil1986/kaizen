@extends('admin.master')

{{-- Content --}}
@section('content')
<h1>Favorites For {{ $event->title }}</h1>

@if(count($users))
    <h3>Total {{count($users)}} Users Favorited This Event</h3>
    <a class="btn btn-default " data-toggle="modal" data-target="#contact" data-original-title>
        Mail to Favorited Users
    </a>

    <div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-labelledby="contactLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="panel-title" id="contactLabel"><span class="glyphicon glyphicon-info-sign"></span> Send Email For Followers.</h4>
                </div>
                {{ Form::open(array('method' => 'POST', 'action' => array('AdminEventsController@mailFavorites',$event->id), 'role'=>'form')) }}
                <div class="modal-body" style="padding: 5px;">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                            <input class="form-control" name="name" placeholder="Your Name" type="text" required autofocus />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                            <input class="form-control" name="email" placeholder="Your E-mail" type="text" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12" style="padding-bottom: 10px;">
                            <input class="form-control" name="subject" placeholder="Subject" type="text" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <textarea style="resize:vertical;" class="form-control" placeholder="Message..." rows="6" name="body" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="panel-footer" style="margin-bottom:-14px;">
                    <input type="submit" class="btn btn-success" value="Send"/>
                    <!--<span class="glyphicon glyphicon-ok"></span>-->
                    <input type="reset" class="btn btn-danger" value="Clear" />
                    <!--<span class="glyphicon glyphicon-remove"></span>-->
                    <button style="float: right;" type="button" class="btn btn-default btn-close" data-dismiss="modal">Close</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@else
    <h3>No Users Have Favorited This Event Yet</h3>
@endif

<h3></h3>
<p>{{ link_to_action('AdminEventsController@create', 'Add new event') }}</p>

<br>
<table class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Username</th>
        <th>Email</th>
    </tr>
    </thead>

    <tbody>
    @foreach($users as $user)
    <tr>

        <td><a href="{{ action('UserController@getProfile',$user->id) }}">{{{ $user->username }}}</a></td>
        <td>{{{ $user->email }}} </td>

    </tr>
    @endforeach
    </tbody>
</table>

@stop
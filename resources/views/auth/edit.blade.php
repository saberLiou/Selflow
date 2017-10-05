@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-sm-4 text-center">
            <img height="300" width="300" src="{{ $user->photo ? $user->photo->file : 'https://placehold.it/250x250/?text=Unknown' }}" alt="{{ $user->photo ? $user->photo->file : 'Unknown' }}" class="img-response img-rounded">
        </div>
        <br>
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4>Edit Profile</h4>
                </div>
                <div class="panel-body">
                    {!! Form::model($user, ['method' => 'PATCH', 'action' => ['UsersController@update', $user->id], 'files' => true]) !!}
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            {!! Form::label('name', "Name:", ['class' => 'control-label']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Edit the name.']) !!}
                            <strong class="text-danger">{{ $errors->first('name') }}</strong>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            {!! Form::label('email', "E-Mail Address:", ['class' => 'control-label']) !!}
                            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Edit the email.']) !!}
                            <strong class="text-danger">{{ $errors->first('email') }}</strong>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {!! Form::label('password', "Password:", ['class' => 'control-label']) !!}
                            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Edit the password.']) !!}
                            <strong class="text-danger">{{ $errors->first('password') }}</strong>
                        </div>
                        <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                            {!! Form::label('role_id', "Role:", ['class' => 'control-label']) !!}
                            {!! Form::select('role_id', array_map('ucfirst', $roles), $user->role_id, ['class' => 'form-control', 'placeholder' => '-- Choose a role. --']) !!}
                            <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
                        </div>
                        <div class="form-group">
                            {!! Form::label('photo', "Photo:") !!}
                            {!! Form::file('photo', ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary center-block"><i class="fa fa-upload"></i> Update</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
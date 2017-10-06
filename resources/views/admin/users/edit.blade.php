@extends('layouts.admin')
@section('content')
    <h1>Edit User</h1>
    <div class="col-sm-4 text-center">
        <img height="250" width="250" src="{{ $user->photo ? Cloudder::secureShow($user->photo->user_directory.$user->photo->file, ['width' => 250, 'height' => 250, 'crop' => 'fill', 'gravity' => 'face']) : 'https://placehold.it/250x250/?text=Unknown' }}" alt="{{ $user->photo ? $user->photo->file : 'Unknown' }}" class="img-response img-rounded">
    </div>
    <div class="col-sm-8">
        {!! Form::model($user, ['method' => 'PATCH', 'action' => ['Admin\UsersController@update', $user->id], 'files' => true]) !!}
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
                {!! Form::label('is_active', "Status:") !!}
                {!! Form::select('is_active', [1 => 'Active', 0 => 'Inactive'], $user->is_active, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                {!! Form::label('photo', "Photo:") !!}
                {!! Form::file('photo', ['class' => 'form-control']) !!}
                <strong class="text-danger">{{ $errors->first('photo') }}</strong>
            </div>
            <div class="col-md-6 col-xs-6">
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Update</button>
                </div>
            </div>
        {!! Form::close() !!}
        {!! Form::open(['method' => 'DELETE', 'action' => ['Admin\UsersController@destroy', $user->id]]) !!}
            <div class="col-md-6 col-xs-6">
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection
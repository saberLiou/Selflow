@extends('layouts.admin')
@section('content')
    <h1>Create User</h1>
    {!! Form::open(['method' => 'POST', 'action' => 'Admin\UsersController@store', 'files' => true]) !!}
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', "Name:", ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter a name.']) !!}
            <strong class="text-danger">{{ $errors->first('name') }}</strong>
        </div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', "E-Mail Address:", ['class' => 'control-label']) !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter an email.']) !!}
            <strong class="text-danger">{{ $errors->first('email') }}</strong>
        </div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            {!! Form::label('password', "Password:", ['class' => 'control-label']) !!}
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter a password.']) !!}
            <strong class="text-danger">{{ $errors->first('password') }}</strong>
        </div>
        <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
            {!! Form::label('role_id', "Role:", ['class' => 'control-label']) !!}
            {!! Form::select('role_id', array_map('ucfirst', $roles), null, ['class' => 'form-control', 'placeholder' => '-- Choose a role. --']) !!}
            <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
        </div>
        <div class="form-group">
            {!! Form::label('is_active', "Status:") !!}
            {!! Form::select('is_active', [1 => 'Active', 0 => 'Inactive'], 0, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('photo', "Photo:") !!}
            {!! Form::file('photo', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group text-center">
            {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
@endsection
@extends('layouts.admin')
@section('content')
    <h1>Create User</h1>
    {!! Form::open(['method' => 'POST', 'action' => 'AdminUsersController@store', 'files' => true]) !!}
        <div class="form-group">
            {!! Form::label('name', "Name:") !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter a name.']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('email', "Email:") !!}
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter an email.']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('password', "Password:") !!}
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter a password.']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('role_id', "Role:") !!}
            {!! Form::select('role_id', array_map('ucfirst', $roles), null, ['class' => 'form-control', 'placeholder' => '-- Choose a role. --']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('is_active', "Status:") !!}
            {!! Form::select('is_active', [1 => 'Active', 0 => 'Inactive'], 0, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::label('photo', "Photo:") !!}
            {!! Form::file('photo', ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
    @include('includes.form_error')
@endsection
@extends('layouts.admin')
@section('content')
    <div class="row">
        @include('includes.form_error')
    </div>
    <h1>Edit User</h1>
    <div class="col-sm-4">
        <img src="{{ $user->photo ? $user->photo->file : 'http://placehold.it/250x250/?text=Unknown' }}" alt="{{ $user->photo ? $user->photo->file : 'Unknown' }}" class="img-response img-rounded">
    </div>
    <div class="col-sm-8">
        {!! Form::model($user, ['method' => 'PATCH', 'action' => ['AdminUsersController@update', $user->id], 'files' => true]) !!}
            <div class="form-group">
                {!! Form::label('name', "Name:") !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Edit the name.']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', "Email:") !!}
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Edit the email.']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password', "Password:") !!}
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Edit the password.']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('role_id', "Role:") !!}
                {!! Form::select('role_id', array_map('ucfirst', $roles), $user->role_id, ['class' => 'form-control', 'placeholder' => '-- Choose a role. --']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('is_active', "Status:") !!}
                {!! Form::select('is_active', [1 => 'Active', 0 => 'Inactive'], $user->is_active, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::label('photo', "Photo:") !!}
                {!! Form::file('photo', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group">
                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
@endsection
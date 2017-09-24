@extends('layouts.admin')
@section('content')
    <h1>Edit User</h1>
    <div class="col-sm-4">
        <img height="250" width="250" src="{{ $user->photo ? $user->photo->file : 'https://placehold.it/250x250/?text=Unknown' }}" alt="{{ $user->photo ? $user->photo->file : 'Unknown' }}" class="img-response img-rounded">
    </div>
    <div class="col-sm-8">
        {!! Form::model($user, ['method' => 'PATCH', 'action' => ['AdminUsersController@update', $user->id], 'files' => true]) !!}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', "Name:") !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Edit the name.']) !!}
                <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                {!! Form::label('email', "Email:") !!}
                {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Edit the email.']) !!}
                <small class="text-danger">{{ $errors->first('email') }}</small>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                {!! Form::label('password', "Password:") !!}
                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Edit the password.']) !!}
                <small class="text-danger">{{ $errors->first('password') }}</small>
            </div>
            <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                {!! Form::label('role_id', "Role:") !!}
                {!! Form::select('role_id', array_map('ucfirst', $roles), $user->role_id, ['class' => 'form-control', 'placeholder' => '-- Choose a role. --']) !!}
                <small class="text-danger">{{ $errors->first('role_id') }}</small>
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
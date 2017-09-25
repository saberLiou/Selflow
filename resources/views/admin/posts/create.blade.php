@extends('layouts.admin')
@section('content')
    <h1>Create Post</h1>
    {!! Form::open(['method' => 'POST', 'action' => 'AdminPostsController@store', 'files' => true]) !!}
        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            {!! Form::label('title', "Title:")!!}
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter a title.']) !!}
            <small class="text-danger">{{ $errors->first('title') }}</small>
        </div>
        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
            {!! Form::label('category_id', "Category:") !!}
            {!! Form::select('category_id', array_map('ucfirst', $categories), 1, ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('category_id') }}</small>
        </div>
        <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
            {!! Form::label('user_id', "Role:") !!}
            {!! Form::select('user_id', $users, null, ['class' => 'form-control', 'placeholder' => '-- Choose an author. --']) !!}
            <small class="text-danger">{{ $errors->first('user_id') }}</small>
        </div>
        <div class="form-group{{ $errors->has('photo_id') ? ' has-error' : '' }}">
            {!! Form::label('photo', "Photo:") !!}
            {!! Form::file('photo', ['class' => 'form-control']) !!}
            <small class="text-danger">{{ $errors->first('photo_id') }}</small>
        </div>
        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
            {!! Form::label('body', "Description:")!!}
            {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 20, 'placeholder' => 'Enter some description.']) !!}
            <small class="text-danger">{{ $errors->first('body') }}</small>
        </div>
        <div class="form-group">
            {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
@endsection
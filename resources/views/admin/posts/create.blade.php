@extends('layouts.admin')
@section('content')
    <!-- @include('includes.tinyeditor') -->
    <h1>Create Post</h1>
    {!! Form::open(['method' => 'POST', 'action' => 'Admin\PostsController@store', 'files' => true]) !!}
        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
            {!! Form::label('title', "Title:", ['class' => 'control-label'])!!}
            {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Enter a title.']) !!}
            <strong class="text-danger">{{ $errors->first('title') }}</strong>
        </div>
        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
            {!! Form::label('category_id', "Category:", ['class' => 'control-label']) !!}
            {!! Form::select('category_id', array_map('ucfirst', $categories), 1, ['class' => 'form-control']) !!}
            <strong class="text-danger">{{ $errors->first('category_id') }}</strong>
        </div>
        <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
            {!! Form::label('user_id', "Role:", ['class' => 'control-label']) !!}
            {!! Form::select('user_id', $users, null, ['class' => 'form-control', 'placeholder' => '-- Choose an author. --']) !!}
            <strong class="text-danger">{{ $errors->first('user_id') }}</strong>
        </div>
        <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
            {!! Form::label('photo', "Photo:", ['class' => 'control-label']) !!}
            {!! Form::file('photo', ['class' => 'form-control']) !!}
            <strong class="text-danger">{{ $errors->first('photo') }}</strong>
        </div>
        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
            {!! Form::label('body', "Description:", ['class' => 'control-label'])!!}
            {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 20, 'placeholder' => 'Enter some description.']) !!}
            <strong class="text-danger">{{ $errors->first('body') }}</strong>
        </div>
        <div class="form-group text-center">
            {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
        </div>
    {!! Form::close() !!}
@endsection
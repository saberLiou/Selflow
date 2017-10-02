@extends('layouts.admin')
@section('content')
    @include('includes.tinyeditor')
    <h1>Edit Post</h1>
    <div class="col-sm-4">
        <img height="250" width="250" src="{{ $post->photo ? $post->photo->file : 'https://placehold.it/250x250/?text=Unknown' }}" alt="{{ $post->photo ? $post->photo->file : 'Unknown' }}" class="img-response img-rounded">
    </div>
    <div class="col-sm-8">
        {!! Form::model($post, ['method' => 'PATCH', 'action' => ['AdminPostsController@update', $post->id], 'files' => true]) !!}
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', "Title:")!!}
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Edit the title.']) !!}
                <small class="text-danger">{{ $errors->first('title') }}</small>
            </div>
            <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                {!! Form::label('category_id', "Category:") !!}
                {!! Form::select('category_id', array_map('ucfirst', $categories), $post->category_id, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('category_id') }}</small>
            </div>
            <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                {!! Form::label('user_id', "Role:") !!}
                {!! Form::select('user_id', $users, $post->user_id, ['class' => 'form-control', 'placeholder' => '-- Choose an author. --']) !!}
                <small class="text-danger">{{ $errors->first('user_id') }}</small>
            </div>
            <div class="form-group{{ $errors->has('photo_id') ? ' has-error' : '' }}">
                {!! Form::label('photo', "Photo:") !!}
                {!! Form::file('photo', ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('photo_id') }}</small>
            </div>
            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                {!! Form::label('body', "Description:")!!}
                {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 20, 'placeholder' => 'Edit the description.']) !!}
                <small class="text-danger">{{ $errors->first('body') }}</small>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary col-sm-2 col-sm-offset-3"><i class="fa fa-upload"></i> Update</button>
            </div>
        {!! Form::close() !!}
        {!! Form::open(['method' => 'DELETE', 'action' => ['AdminPostsController@destroy', $post->id]]) !!}
            <div class="form-group">
                <button type="submit" class="btn btn-danger col-sm-2 col-sm-offset-2"><i class="fa fa-trash"></i> Delete</button>
            </div>
        {!! Form::close() !!}
    </div>
@endsection
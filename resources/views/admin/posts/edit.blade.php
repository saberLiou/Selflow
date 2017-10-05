@extends('layouts.admin')
@section('content')
    <!-- @include('includes.tinyeditor') -->
    <h1>Edit Post</h1>
    <div class="col-sm-4 text-center">
        <img height="250" width="250" src="{{ $post->photo ? $post->photo->file : 'https://placehold.it/250x250/?text=Unknown' }}" alt="{{ $post->photo ? $post->photo->file : 'Unknown' }}" class="img-response img-rounded">
    </div>
    <div class="col-sm-8">
        {!! Form::model($post, ['method' => 'PATCH', 'action' => ['Admin\PostsController@update', $post->id], 'files' => true]) !!}
            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', "Title:", ['class' => 'control-label'])!!}
                {!! Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Edit the title.']) !!}
                <strong class="text-danger">{{ $errors->first('title') }}</strong>
            </div>
            <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                {!! Form::label('category_id', "Category:", ['class' => 'control-label']) !!}
                {!! Form::select('category_id', array_map('ucfirst', $categories), $post->category_id, ['class' => 'form-control']) !!}
                <strong class="text-danger">{{ $errors->first('category_id') }}</strong>
            </div>
            <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
                {!! Form::label('user_id', "Role:", ['class' => 'control-label']) !!}
                {!! Form::select('user_id', $users, $post->user_id, ['class' => 'form-control', 'placeholder' => '-- Choose an author. --']) !!}
                <strong class="text-danger">{{ $errors->first('user_id') }}</strong>
            </div>
            <div class="form-group">
                {!! Form::label('photo', "Photo:", ['class' => 'control-label']) !!}
                {!! Form::file('photo', ['class' => 'form-control']) !!}
            </div>
            <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                {!! Form::label('body', "Description:", ['class' => 'control-label'])!!}
                {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 20, 'placeholder' => 'Edit the description.']) !!}
                <strong class="text-danger">{{ $errors->first('body') }}</strong>
            </div>
            <div class="col-md-6 col-xs-6">
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Update</button>
                </div>
            </div>
        {!! Form::close() !!}
        {!! Form::open(['method' => 'DELETE', 'action' => ['Admin\PostsController@destroy', $post->id]]) !!}
            <div class="col-md-6 col-xs-6">
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection
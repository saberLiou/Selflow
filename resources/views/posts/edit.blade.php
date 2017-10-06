@extends('layouts.app')
@section('content')
    <!-- @include('includes.tinyeditor') -->
    <div class="container">
        <div class="col-sm-4 text-center">
            <img height="300" width="300" src="{{ $post->photo ? Cloudder::secureShow($post->photo->post_directory.$post->photo->file, ['width' => 300, 'height' => 300]) : 'https://placehold.it/300x300/?text=Unknown' }}" alt="{{ $post->photo ? $post->photo->file : 'Unknown' }}" class="img-response img-rounded">
        </div>
        <br>
        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4>Edit the Post</h4>
                </div>
                <div class="panel-body">
                    {!! Form::model($post, ['method' => 'PATCH', 'action' => ['PostsController@update', $post->id], 'files' => true]) !!}
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
                        <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                            {!! Form::label('photo', "Photo:", ['class' => 'control-label']) !!}
                            {!! Form::file('photo', ['class' => 'form-control']) !!}
                            <strong class="text-danger">{{ $errors->first('photo') }}</strong>
                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"></input>
                        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                            {!! Form::label('body', "Description:", ['class' => 'control-label'])!!}
                            {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 20, 'placeholder' => 'Edit the description.']) !!}
                            <strong class="text-danger">{{ $errors->first('body') }}</strong>
                        </div>
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group text-center">
                                {!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                    {!! Form::open(['method' => 'DELETE', 'action' => ['PostsController@destroy', $post->id]]) !!}
                        <div class="col-md-6 col-xs-6">
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
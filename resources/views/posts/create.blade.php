@extends('layouts.app')
@section('content')
    <!-- @include('includes.tinyeditor') -->
    <div class="container">
        <div class="col-sm-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h4>Write a Post</h4>
                </div>
                <div class="panel-body">
                    {!! Form::open(['method' => 'POST', 'action' => 'PostsController@store', 'files' => true]) !!}
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
                        <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
                            {!! Form::label('photo', "Photo:", ['class' => 'control-label']) !!}
                            {!! Form::file('photo', ['class' => 'form-control']) !!}
                            <strong class="text-danger">{{ $errors->first('photo') }}</strong>
                        </div>
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"></input>
                        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                            {!! Form::label('body', "Description:", ['class' => 'control-label'])!!}
                            {!! Form::textarea('body', null, ['class' => 'form-control', 'rows' => 20, 'placeholder' => 'Enter some description.']) !!}
                            <strong class="text-danger">{{ $errors->first('body') }}</strong>
                        </div>
                        <div class="form-group text-center">
                            {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.admin')
@section('content')
    <h1>Edit Category</h1>
    {!! Form::model($category, ['method' => 'PATCH', 'action' => ['AdminCategoriesController@update', $category->id]]) !!}
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', "Name:") !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Edit the name.']) !!}
            <small class="text-danger">{{ $errors->first('name') }}</small>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary col-sm-2 col-sm-offset-3"><i class="fa fa-upload"></i> Update</button>
        </div>
    {!! Form::close() !!}
    {!! Form::open(['method' => 'DELETE', 'action' => ['AdminCategoriesController@destroy', $category->id]]) !!}
        <button type="submit" class="btn btn-danger col-sm-2 col-sm-offset-2"><i class="fa fa-trash"></i> Delete</button>
    {!! Form::close() !!}
@endsection
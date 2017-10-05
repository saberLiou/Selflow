@extends('layouts.admin')
@section('content')
    <h1>Edit Category</h1>
    {!! Form::model($category, ['method' => 'PATCH', 'action' => ['Admin\CategoriesController@update', $category->id]]) !!}
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', "Name:", ['class' => 'control-label']) !!}
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Edit the name.']) !!}
            <strong class="text-danger">{{ $errors->first('name') }}</strong>
        </div>
        <div class="col-md-6 col-xs-6">
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Update</button>
            </div>
        </div>
    {!! Form::close() !!}
    {!! Form::open(['method' => 'DELETE', 'action' => ['Admin\CategoriesController@destroy', $category->id]]) !!}
        <div class="col-md-6 col-xs-6">
            <div class="form-group text-center">
                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
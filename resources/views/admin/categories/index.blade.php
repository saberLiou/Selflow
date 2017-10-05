@extends('layouts.admin')
@section('content')
    @if (Session::has('delete_category'))
        <div class="alert alert-info">{{ session('delete_category') }}</div>
    @endif
    <h1>Categories</h1>
    <div class="col-sm-6">
        {!! Form::open(['method' => 'POST', 'action' => 'Admin\CategoriesController@store']) !!}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', "Name:", ['class' => 'control-label']) !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter a name.']) !!}
                <strong class="text-danger">{{ $errors->first('name') }}</strong>
            </div>
            <div class="form-group">
                {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
            </div>
        {!! Form::close() !!}
    </div>
    <div class="col-sm-6">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Created Time</th>
                    <th>Updated Time</th>
                    <th>Edit Category</th>
                </tr>
            </thead>
            <tbody>
                @if (count($categories) > 0)
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->id }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->created_at->diffForHumans() }}</td>
                            <td>{{ $category->updated_at->diffForHumans() }}</td>
                            @if ($category->id == 1)
                                <td>Default cannot edit.</td>
                            @else
                                <td><a href="{{ route('admin.categories.edit', $category->id) }}"><button class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button></a></td>
                            @endif
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
@endsection
@extends('layouts.admin')
@section('content')
    @if (Session::has('delete_photo'))
        <div class="alert alert-info">{{ session('delete_photo') }}</div>
    @endif
    <h1>Photos</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>File Name</th>
                <th>Owned by</th>
                <th>Created Time</th>
                <th>Updated Time</th>
                <th>Delete Photo</th>
            </tr>
        </thead>
        <tbody>
            @if ($photos)
                @foreach ($photos as $photo)
                    <tr>
                        <td>{{ $photo->id }}</td>
                        <td><img height="50" width="50" src="{{ $photo->file }}" alt="{{ $photo->file }}"></td>
                        <td>{{ explode('/', $photo->file)[2] }}</td>
                        @if ($photo->user)
                            <td>{{ 'User: '.$photo->user->name }}</td>
                        @elseif ($photo->post)
                            <td>{{ 'Post: '.$photo->post->title }}</td>
                        @else
                            <td>{{ "None." }}</td>
                        @endif
                        <td>{{ $photo->created_at->diffForHumans() }}</td>
                        <td>{{ $photo->updated_at->diffForHumans() }}</td>
                        <td>
                            {!! Form::open(['method' => 'DELETE', 'action' => ['AdminPhotosController@destroy', $photo->id]]) !!}
                                <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
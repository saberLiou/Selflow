@extends('layouts.admin')
@section('content')
    @if (Session::has('delete_user'))
        <div class="alert alert-info">{{ session('delete_user') }}</div>
    @endif
    <h1>Users</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created Time</th>
                <th>Updated Time</th>
                <th><div class="col-sm-offset-3">Action<div></th>
            </tr>
        </thead>
        <tbody>
            @if ($users)
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><img height="50" width="50" src="{{ $user->photo ? $user->photo->file : 'https://placehold.it/50x50/?text=Unknown' }}" alt="{{ $user->photo ? $user->photo->file : 'Unknown' }}"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role->name) }}</td>
                        <td>{{ $user->is_active ? "Active" : "Inactive" }}</td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td>{{ $user->updated_at->diffForHumans() }}</td>
                        <td>
                            <div class="row">
                                <div class="col-sm-4">
                                    <a href="{{ route('users.edit', $user->id) }}"><button class="btn btn-primary"><i class="fa fa-wrench"></i> Edit</button></a>
                                </div>
                                <div class="col-sm-5">
                                    {!! Form::open(['method' => 'DELETE', 'action' => ['AdminUsersController@destroy', $user->id]]) !!}
                                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
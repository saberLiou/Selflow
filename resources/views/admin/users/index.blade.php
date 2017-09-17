@extends('layouts.admin')
@section('content')
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
                <th>Edit User</th>
            </tr>
        </thead>
        <tbody>
            @if ($users)
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><img height="50" src="{{ $user->photo ? $user->photo->file : 'http://placehold.it/50x50/?text=Unknown' }}" alt="{{ $user->photo ? $user->photo->file : 'Unknown' }}"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ ucfirst($user->role->name) }}</td>
                        <td>{{ $user->is_active ? "Active" : "Inactive" }}</td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td>{{ $user->updated_at->diffForHumans() }}</td>
                        <td><a href="{{ route('users.edit', $user->id) }}"><button class="btn btn-primary">Edit</button></a></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
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
                <th>E-Mail Address</th>
                <th>Password</th>
                <th>Role</th>
                <th>Status</th>
                <th>Created Time</th>
                <th>Updated Time</th>
                <th>Edit User</th>
            </tr>
        </thead>
        <tbody>
            @if (count($users) > 0)
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td><img height="50" width="50" src="{{ $user->photo ? Cloudder::secureShow($user->photo->user_directory.$user->photo->file) : 'https://placehold.it/50x50/?text=Unknown' }}" alt="{{ $user->photo ? $user->photo->file : 'Unknown' }}"></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>@for ($i = 0; $i < $user->pwd_num; $i++)*@endfor</td>
                        <td>{{ ucfirst($user->role->name) }}</td>
                        <td>{{ $user->is_active ? "Active" : "Inactive" }}</td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td>{{ $user->updated_at->diffForHumans() }}</td>
                        <td><a href="{{ route('admin.users.edit', $user->id) }}"><button class="btn btn-primary"><i class="fa fa-edit"></i> Edit</button></a></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
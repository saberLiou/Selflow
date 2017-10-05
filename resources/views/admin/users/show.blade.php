@extends('layouts.admin')
@section('content')
    <div class="col-md-4 text-center">
        <img height="250" width="250" src="{{ $user->photo ? $user->photo->file : 'https://placehold.it/250x250/?text=Unknown' }}" alt="{{ $user->photo ? $user->photo->file : 'Unknown' }}" class="img-response img-rounded">
    </div>
    <div class="col-md-8 text-center">
        <table class="table">
            <thead>
                <h1>Personal Information</h1>
            </thead>
            <tbody>
                <tr>
                    <td><h4>Name</h4></td>
                    <td><h5>{{ $user->name }}</h5></td>
                </tr>
                <tr>
                    <td><h4>Email</h4></td>
                    <td><h5>{{ $user->email }}</h5></td>
                </tr>
                <tr>
                    <td><h4>Password</h4></td>
                    <td><h5>@for ($i = 0; $i < $user->pwd_num; $i++)* @endfor</h5></td>
                </tr>
                <tr>
                    <td><h4>Role</h4></td>
                    <td><h5>{{ ucfirst($user->role->name) }}</h5></td>
                </tr>
                @if ($user->role_id == 1)
                    <tr>
                        <td><h4>Admin</h4></td>
                        <td><h5>{!! $user->isAdmin() ? "<b style='color:green;'>Active</b>" : "<b style='color:red;'>Inactive</b>" !!}</h5></td>
                    </tr>
                @endif
                <tr>
                    <td><h4>Post</h4></td>
                    <td><h5>{!! $user->isAuthor() ? "<b style='color:green;'>Able</b>" : "<b style='color:red;'>Inable</b>" !!}</h5></td>
                </tr>
                <tr>
                    <td><h4>Comment/Reply</h4></td>
                    <td><h5>{!! $user->is_active ? "<b style='color:green;'>Able</b>" : "<b style='color:red;'>Inable</b>" !!}</h5></td>
                </tr>
                <tr>
                    <td><h4>Registered</h4></td>
                    <td><h5>{{ $user->created_at->diffForHumans() }}</h5></td>
                </tr>
            </tbody>
        </table>
        <a href="{{ route('admin.users.edit', $user->id) }}"><button class="btn btn-primary center-block">Edit Profile</button></a><br>
    </div>
@endsection
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User, App\Role, App\Photo;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Session;

class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\UsersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        // return $request->all();
        $input = $request->all();
        $input['password'] = bcrypt($request->password);

        if ($file = $request->file('photo')){
            $name = $file->getClientOriginalName();
            /* Save file original name into database. */
            $photo = Photo::create(['file' => $name]);
            /* Copy file into /public/images. */
            $file->move($photo->directory, $name);
            /* Save photo id into users table. */
            $input['photo_id'] = $photo->id;
        }
        User::create($input);
        return redirect('/admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // not used.
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::pluck('name', 'id')->all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request, $id)
    {   
        // return $request->all();
        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        $user = User::findOrFail($id);

        if ($file = $request->file('photo')){
            $name = $file->getClientOriginalName();
            if ($user->photo){
                /* Update the file in /public/images. */
                unlink(public_path().$user->photo->file);
                $file->move($user->photo->directory, $name);
                /* Update file original name into database. */
                Photo::findOrFail($user->photo_id)->update(['file' => $name]);
            }
            else{
                /* Save file original name into database. */
                $photo = Photo::create(['file' => $name]);
                /* Save the file in /public/images. */
                $file->move($photo->directory, $name);
                /* Save photo id into users table. */
                $input['photo_id'] = $photo->id;
            }
        }
        $user->update($input);
        return redirect('/admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        Session::flash('delete_user', 'The No.'.$user->id.' user '.$user->name.' has been deleted.');
        if ($user->photo){
            /* Delete user photo from images storage path. */
            unlink(public_path().$user->photo->file);
            /* Delete user photo record from database. */
            $user->photo->delete();
        }

        /* Cascade delete photos of user's posts. */
        if ($user->posts){
            foreach ($user->posts as $post){
                if ($post->photo){
                    /* Delete post photo from images storage path. */
                    unlink(public_path().$post->photo->file);
                    /* Delete post photo record from database. */
                    $post->photo->delete();
                }
            }
        }
        
        $user->delete();
        return redirect('/admin/users');
    }
}

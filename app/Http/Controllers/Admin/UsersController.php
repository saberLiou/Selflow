<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User, App\Role, App\Photo;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UsersRequest;
use Illuminate\Support\Facades\Session;

class UsersController extends Controller
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
        $input['pwd_num'] = strlen($request->password);
        $input['password'] = bcrypt($request->password);

        if ($file = $request->file('photo')){
            $name = $file->getClientOriginalName();
            /* Save file name into database first. */
            $photo = Photo::create(['file' => $name]);
            /* Slug id with file name to avoid photos with same file name
               unlinked at the delete moment. */
            $name = strval($photo->id)."_".substr($photo->file, 8);
            /* Update the slugged file name into database. */
            $photo->update(['file' => $name]);
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
        $user = Auth::user();
        return view('admin.users.show', compact('user'));
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
        //return $request->all();
        $input = $request->all();
        $input['pwd_num'] = strlen($request->password);
        $input['password'] = bcrypt($request->password);
        $user = User::findOrFail($id);

        if ($file = $request->file('photo')){
            $name = $file->getClientOriginalName();
            if (count($user->photo) > 0){
                /* Remove the file in /public/images first. */
                unlink(public_path().$user->photo->file);
                /* Slug id with file name to avoid photos with same file name
                   unlinked at the delete moment. */
                $name = strval($user->photo_id)."_".$name;
                /* Update the slugged file name into database. */
                Photo::findOrFail($user->photo_id)->update(['file' => $name]);
                /* Save the file in /public/images. */
                $file->move($user->photo->directory, $name);
            }
            else{
                /* Save file name into database first. */
                $photo = Photo::create(['file' => $name]);
                /* Slug id with file name to avoid photos with same file name
                   unlinked at the delete moment. */
                $name = strval($photo->id)."_".substr($photo->file, 8);
                /* Update the slugged file name into database. */
                $photo->update(['file' => $name]);
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
        if (count($user->photo) > 0){
            /* Delete user photo from images storage path. */
            unlink(public_path().$user->photo->file);
            /* Delete user photo record from database. */
            $user->photo->delete();
        }

        /* Cascade delete photos of user's posts. */
        if (count($user->posts) > 0){
            foreach ($user->posts as $post){
                if (count($post->photo) > 0){
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

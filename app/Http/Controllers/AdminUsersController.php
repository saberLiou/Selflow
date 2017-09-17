<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User, App\Role, App\Photo;

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
    public function store(Request $request)
    {
        /* Request validation. */
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role_id' => 'required'
        ]);

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
        return view('admin.users.show');
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
    public function update(Request $request, $id)
    {
        /* Request validation. */
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);
        
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
        User::findOrFail($id)->update($input);
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
        //
    }
}

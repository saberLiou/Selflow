<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User, App\Role, App\Photo;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UsersRequest;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('auth.index', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // RegisterController@showRegistrationForm.
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // RegisterController@register.
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('auth.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        if ($user->role_id == 1){
            $roles = Role::pluck('name', 'id')->all();
        }
        else{
            $roles = Role::where('id', '!=', '1')->pluck('name', 'id')->all();
        }
        return view('auth.edit', compact('user', 'roles'));
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
        $input['pwd_num'] = strlen($request->password);
        $input['password'] = bcrypt($request->password);
        $user = Auth::user();

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
        return redirect('/home/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // not uesd.
    }
}

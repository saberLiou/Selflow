<?php

namespace App\Http\Controllers\Auth;

use App\User, App\Photo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use JD\Cloudder\Facades\Cloudder;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed',
            'role' => 'required',
            'photo' => 'image'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'pwd_num' => strlen($data['password']),
            'role_id' => $data['role'],
            'is_active' => 1,
            'photo_id' => isset($data['photo_id']) ? $data['photo_id'] : null
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $input = $request->all();
        if ($file = $request->file('photo')){
            /* Trim file extension. */
            $extension = ".".$file->getClientOriginalExtension();
            $name = substr($file->getClientOriginalName(), 0, -strlen($extension));
            /* Save file name into database. */
            $photo = Photo::create(['file' => $name]);
            /* Slug id with file name to avoid photos with same file name
               unlinked at the delete moment. */
            $name = strval($photo->id)."_".$photo->file;
            /* Update the slugged file name into database. */
            $photo->update(['file' => $name]);
            /* Copy file into /public/images. */
            // $file->move($photo->directory, $name);
            Cloudder::upload($file, $name, ['folder' => $photo->user_directory]);
            /* Save photo id into users table. */
            $input['photo_id'] = $photo->id;
        }

        $this->guard()->login($this->create($input));
        return redirect($this->redirectPath());
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Photo;
use Illuminate\Support\Facades\Session;

class AdminPhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::all();
        return view('admin.photos.index', compact('photos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.photos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        /* Save file original name into database. */
        $photo = Photo::create(['file' => $name]);
        /* Copy file into /public/images. */
        $file->move($photo->directory, $name);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // not uesd.
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // not used.
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
        // not used.
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);
        Session::flash('delete_photo', 'The No.'.$photo->id.' photo '.explode('/', $photo->file)[2].' has been deleted.');
        /* Delete post photo from images storage path. */
        unlink(public_path().$photo->file);
        /* Delete post photo record from database. */
        $photo->delete();
        return redirect('/admin/photos');
    }

    public function multiDestroy(Request $request){
        // return dd($request->all());
        $photos = Photo::findOrFail($request->delete_photos);
        foreach ($photos as $photo){
            unlink(public_path().$photo->file);
            $photo->delete();
        }
        return redirect('/admin/photos');
    }
}

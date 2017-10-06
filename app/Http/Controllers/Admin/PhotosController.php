<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Photo;
use Illuminate\Support\Facades\Session;
use JD\Cloudder\Facades\Cloudder;

class PhotosController extends Controller
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
        if ($request->file('file')->isValid()){
            $file = $request->file('file');
            /* Trim file extension. */
            $extension = ".".$file->getClientOriginalExtension();
            $name = substr($file->getClientOriginalName(), 0, -strlen($extension));
            /* Save file name into database first. */
            $photo = Photo::create(['file' => $name]);
            /* Slug id with file name to avoid photos with same file name
            unlinked at the delete moment. */
            $name = strval($photo->id)."_".$photo->file;
            /* Update the slugged file name into database. */
            $photo->update(['file' => $name]);
            /* Copy file into /public/images. */
            // $file->move($photo->directory, $name);
            Cloudder::upload($file, $name, ['folder' => $photo->directory]);
        }
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
        Session::flash('delete_photo', 'The No.'.$photo->id.' photo '.$photo->file.' has been deleted.');
        /* Delete photo from /public/images. */
        // unlink(public_path().$photo->file);
        Cloudder::destroy($photo->file, ['folder' => $photo->directory, 'invalidate' => true]);
        /* Delete photo record from database. */
        $photo->delete();
        return redirect('/admin/photos');
    }

    public function multiDestroy(Request $request){
        // return dd($request->all());
        $photos = Photo::findOrFail($request->delete_photos);

        $id_files = [];
        foreach ($photos as $photo){
            /* Delete photo from /public/images. */
            // unlink(public_path().$photo->file);
            $id_files[$photo->id] = $photo->file;
            Cloudder::destroy($photo->file, ['folder' => $photo->directory, 'invalidate' => true]);
            /* Delete photo record from database. */
            $photo->delete();
        }

        $alert = 'The ';
        foreach ($id_files as $id => $file){
            $alert .= 'No.'.$id.' photo '.$file.', ';
        }
        Session::flash('delete_photo', substr($alert, 0, -2).' has been deleted.');
        
        return redirect('/admin/photos');
    }
}

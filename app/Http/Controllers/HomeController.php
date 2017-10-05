<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post, App\Category;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $posts = Category::findBySlugOrFail($slug)->posts;
        return view('home', compact('posts'));
    }
}

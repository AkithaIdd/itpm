<?php

namespace App\Http\Controllers;

use App\Course;


class HomeController extends Controller
{
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::where('published', 1)->orderBy('id','desc')->get();
        return view('index', compact('courses'));
    }
    public function courses(){
        $courses = Course::where('published', 1)->orderBy('id','desc')->get();
        return view('courses', compact('courses'));
    }
    
}

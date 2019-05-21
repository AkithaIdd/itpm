<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function courses(){
        return view('courses');
    }
    public function profile(){
        return view('profile');
    }
    public function library(){
        $courses = Course::where('published', 1)->orderBy('id', 'desc')->get();
        return view('library', compact('courses'));
    }
}

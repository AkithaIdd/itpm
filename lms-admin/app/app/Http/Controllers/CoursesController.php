<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function show($course_id){
        $course = Course::where('id', $course_id)-> firstOrFail();
        return view('course', compact('course'));
    }

}  
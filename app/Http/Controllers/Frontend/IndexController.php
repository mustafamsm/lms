<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function CourseDetails($id,$slug){
        $course = Course::with('category','subcategory' ,'user','goals','lectures','sections')->findOrFail($id);
        $categories=Category::latest()->get();
        return view('frontend.course.course_details',compact('course','categories'));
    }
}

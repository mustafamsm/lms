<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;

class IndexController extends Controller
{
    public function CourseDetails($id,$slug){
        $course = Course::with('category','subcategory' ,'user','goals','lectures','sections')->findOrFail($id);
        $categories=Category::latest()->get();
        
    $relatedCourses = $course->category
        ->courses()
        ->where('id', '!=', $course->id)
        ->latest()
        ->limit(3)
        ->get();
        return view('frontend.course.course_details',compact('course','categories','relatedCourses'));
    }

    public function CategoryCourse($slug, Request $request)
    {
        $category = Category::where('category_slug', $slug)->firstOrFail();
        $courses = $category->courses()->where('status', 1);

        // Sorting logic
        switch ($request->sort) {
            case 'newest':
                $courses->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $courses->orderBy('created_at', 'asc');
                break;
            case 'high-rated':
                $courses->orderBy('rating', 'desc');
                break;
            case 'popular-courses':
                $courses->orderBy('views', 'desc');
                break;
            case 'high-to-low':
                $courses->orderBy('selling_price', 'desc');
                break;
            case 'low-to-high':
                $courses->orderBy('selling_price', 'asc');
                break;
            default:
                $courses->latest();
        }

        

        // Add more filters as needed...

        $courses = $courses->get();

      
        return view('frontend.category.category_all', compact('category', 'courses'));
    }

    public function SubCategoryCourse($slug,Request $request){
        $subcategory=SubCategory::with('category')->where('category_slug',$slug)
        ->firstOrFail();
        $courses=$subcategory->courses()->where('status',1);
        $categories=Category::latest()->get();

        // Sorting logic
        switch ($request->sort) {
            case 'newest':
                $courses->orderBy('created_at', 'desc');
                break;
            case 'oldest':
                $courses->orderBy('created_at', 'asc');
                break;
            case 'high-rated':
                $courses->orderBy('rating', 'desc');
                break;
            case 'popular-courses':
                $courses->orderBy('views', 'desc');
                break;
            case 'high-to-low':
                $courses->orderBy('selling_price', 'desc');
                break;
            case 'low-to-high':
                $courses->orderBy('selling_price', 'asc');
                break;
            default:
                $courses->latest();
        }

          $courses = $courses->get();
      return view('frontend.category.subcategory_all',compact('courses','subcategory','categories'));
    }
}

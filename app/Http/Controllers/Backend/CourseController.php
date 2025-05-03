<?php

namespace App\Http\Controllers\Backend;

use App\Models\Course;
use App\Models\Category;
use App\Models\Course_goal;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreCourseRequest;
use Intervention\Image\Laravel\Facades\Image;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::user()->id;
        $courses = Course::where('instructor_id', $id)
        ->with('goals')
        ->orderBy('id', 'desc')
        ->get();

        return view('instructor.courses.all_course', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('instructor.courses.add_course', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $thumbnailPath = 'upload/course/thumbnail/';
        $videoPath = 'upload/course/video/';

        if (!File::exists(public_path($thumbnailPath))) {
            File::makeDirectory(public_path($thumbnailPath), 0755, true);
        }
        
        if (!File::exists(public_path($videoPath))) {
            File::makeDirectory(public_path($videoPath), 0755, true);
        }
        $course = new Course();
        $course->course_name = $request->course_name;
        $course->course_name_slug = Str::slug($request->course_name, '-');
        $course->course_title = $request->course_title;
        $course->category_id = $request->category_id;
        $course->subcategory_id = $request->subcategory_id;
        $course->instructor_id = Auth::user()->id;
        $course->selling_price = $request->selling_price;
        $course->discount_price = $request->discount_price;
        $course->duration = $request->duration;
        $course->resources = $request->resources;
        $course->label = $request->label;
        $course->prerequisites = $request->prerequisites;
        $course->description = $request->description;
        $course->bestseller = $request->bestseller;
        $course->featured = $request->featured;
        $course->highestreated = $request->highestreated;
        $course->status = 1; // Default status to 1 (active)
        $course->certificate = $request->certificate;

        // Handle course image upload
        if ($request->hasFile('course_image')) {
            $course->course_image = $this->uploadFile($request->file('course_image'), $thumbnailPath, ['width' => 370, 'height' => 246]);

        }
         
        // Handle course video upload
        if ($request->hasFile('video')) {
            $course->video = $this->uploadFile($request->file('video'), $videoPath);

        }

        // Save the course
        try {
            $course->save();
        } catch (\Exception $e) {
            $notification = array(
                'message' => $e->getMessage(),
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        // Course goals
        if ($request->has('course_goals')) {
            $goals = array_map(function ($goal) use ($course) {
                return [
                    'course_id' => $course->id,
                    'goal_name' => $goal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }, $request->course_goals);
    
            Course_goal::insert($goals);
        }

        $notification = array(
            'message' => 'Course added successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.course')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateGoal(Request $request,$id){
        $request->validate([
            'goal_name' => 'required|string|max:255',
        ]);
    
        $goal = Course_Goal::findOrFail($id);
        $goal->goal_name = $request->goal_name;
        $goal->save();
        
      
        $notification = array(
            'message' => 'Goals Updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.course')->with($notification);
    }

    public function GetSubCategory($category_id)
    {
        $subcategories = SubCategory::where('category_id', $category_id)->pluck('category_name', 'id');
        return response()->json($subcategories);
    }

    private function uploadFile($file, $path, $resize = null)
    {
        $fileName = now()->format('YmdHi') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        if ($resize) {
            Image::read($file)
                ->resize($resize['width'], $resize['height'])
                ->save(public_path($path . $fileName));
        } else {
            $file->move(public_path($path), $fileName);
        }

        return $path . $fileName;
    }
}

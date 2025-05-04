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
            ->with('category')


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

        $course = Course::findOrFail($id);
        $course_goals = Course_goal::where('course_id', $id)->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::where('category_id', $course->category_id)->get();
        return view('instructor.courses.edit_course', compact('course', 'course_goals','categories', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'course_title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'subcategory_id' => 'required|exists:sub_categories,id',
            'selling_price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'duration' => 'required|string|max:255',
            'resources' => 'nullable|string|max:255',
            'label' => 'nullable|string|max:255',
            'prerequisites' => 'nullable|string|max:255',
            'description' => 'required|string',
            'certificate' => 'nullable|string',
            'bestseller' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'highestrated' => 'nullable|boolean',

        ]);
        $course = Course::findOrFail($id)->update([
            'course_name' => $request->course_name,
            'course_name_slug' => Str::slug($request->course_name, '-'),
            'course_title' => $request->course_title,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'instructor_id' => Auth::user()->id,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'duration' => $request->duration,
            'resources' => $request->resources,
            'label' => $request->label,
            'prerequisites' => $request->prerequisites,
            'description' => $request->description,
            'certificate' => $request->certificate,
            'highestrated' => $request->highestrated,
            'bestseller' => $request->bestseller,
            'featured' => $request->featured,
        ]);


        $notification = array(
            'message' => 'Course updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.course')->with($notification);
    }

    public function updateCourseImage(Request $request,$id) {
        $request->validate([
            'course_image'=>'nullable|mimes:png,jpg,jpeg',
        ]);
        $course = Course::findOrFail($id);
        if($request->hasFile('course_image')){
            if (File::exists($course->course_image)) {
                File::delete($course->course_image);
            }
            $thumbnailPath = 'upload/course/thumbnail/';
            $course->course_image = $this->uploadFile($request->file('course_image'), $thumbnailPath, ['width' => 370, 'height' => 246]);
        }
        $course->save();
        $notification = array(
            'message' => 'Course image updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function updateCourseVideo(Request $request,$id) {
      
        $request->validate([
            'video'=>'nullable|mimes:mp4,mov,ogg,qt|max:102400',
        ]);
        
        $course = Course::findOrFail($id);
        
        if($request->hasFile('video')){
           
            if (File::exists($course->video)) {
                File::delete($course->video);
            }
            $videoPath = 'upload/course/video/';
            $course->video = $this->uploadFile($request->file('video'), $videoPath);

        }
        $course->save();
        $notification = array(
            'message' => 'Course video updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function updateCourseGoal(Request $request, $id)
    {
        $request->validate([
            'course_goals' => 'required|array',
            'course_goals.*' => 'string|max:255',
        ]);
        
        if($request->course_goals==null){
            return back();
        }
        Course_goal::where('course_id', $id)->delete();        
       foreach ($request->course_goals as $goal) {
            Course_goal::create([
                'course_id' => $id,
                'goal_name' => $goal,
            ]);
        }
        $notification = array(
            'message' => 'Course goals updated successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    /**
     * 
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        if (File::exists($course->course_image)) {
            File::delete($course->course_image);
        }
        if (File::exists($course->video)) {
            File::delete($course->video);
        }
        $course->delete();
        Course_goal::where('course_id', $id)->delete();
        $notification = array(
            'message' => 'Course deleted successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function updateGoal(Request $request, $id)
    {
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

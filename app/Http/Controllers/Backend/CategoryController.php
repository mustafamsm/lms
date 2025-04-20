<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all categories from the database
        $categories = Category::latest()->get();


        // Return the view with the categories data
        return view('admin.backend.category.all_category', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.backend.category.add_category');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Path where you want to save the image
        $savePath = 'upload/category_images';

        // Ensure the directory exists
        if (!File::exists($savePath)) {
            File::makeDirectory($savePath, 0755, true); // recursive = true
        }

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::read($image)->resize(370, 246)->save($savePath . '/' . $name_gen);
        $save_url = $savePath . '/' . $name_gen;

        Category::insert([
            'category_name' => $request->category_name,
            'category_slug' => Str::slug($request->category_name, '-'),
            'image' => $save_url
        ]);
        $notification = array(
            'message' => 'Category Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('category.all')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($slug)
    {
        // Fetch the category by slug instead of ID
        $category = Category::where('category_slug', $slug)->firstOrFail();

        // Return the edit view with the category data
        return view('admin.backend.category.edit_category', compact('category'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $category = Category::findOrFail($id);

        if ($request->file('image')) {
            // Remove the old image if it exists
            if (File::exists($category->image)) {
                File::delete($category->image);
            }
            // Path where you want to save the image
            $savePath = 'upload/category_images';
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::read($image)->resize(370, 246)->save($savePath . '/' . $name_gen);
            $save_url = $savePath . '/' . $name_gen;
            
            Category::findOrFail($id)->update([
                'category_name' => $request->category_name,
                'category_slug' => Str::slug($request->category_name, '-'),
                'image' => $save_url
            ]);
            $notification = array(
                'message' => 'Category Updated with image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('category.all')->with($notification);
        }else{
             
            Category::findOrFail($id)->update([
                'category_name' => $request->category_name,
                'category_slug' => Str::slug($request->category_name, '-'),
                
            ]);
            $notification = array(
                'message' => 'Category Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('category.all')->with($notification);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $category=Category::findOrFail($id);
        $img=$category->image;
        unlink($img);
        $category->delete();
        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('category.all')->with($notification);
    }
}

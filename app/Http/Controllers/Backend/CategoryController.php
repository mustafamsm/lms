<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SubCategory;
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
        } else {

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

        $category = Category::findOrFail($id);
        $img = $category->image;
        unlink($img);

        $category->delete();
        $notification = array(
            'message' => 'Category Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('category.all')->with($notification);
    }
    ///////////subcategory methods

    public function AllSubCategory()
    {
        $subcategories = SubCategory::with('category')->latest()->get();


        // Return the view with the subcategories data
        return view('admin.backend.subcategory.all_subcategory', compact('subcategories'));
    }

    public function AddSubCategory()
    {
        $categories = Category::latest()->get();
        return view('admin.backend.subcategory.add_subcategory', compact('categories'));
    }

    public function StoreSubCategory(Request $request)
    {

        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',

        ], [
            'category_name.required' => 'Please Enter SubCategory Name',
            'category_id.required' => 'Please Select Category',
            'category_id.exists' => 'Selected Category does not exist',
        ]);

        // Path where you want to save the image
        $savePath = 'upload/subcategory_images';

        // Ensure the directory exists
        if (!File::exists($savePath)) {
            File::makeDirectory($savePath, 0755, true); // recursive = true
        }

        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        Image::read($image)->resize(370, 246)->save($savePath . '/' . $name_gen);
        $save_url = $savePath . '/' . $name_gen;


        SubCategory::create([
            'category_name' => $request->category_name,
            'category_id' => $request->category_id,
            'category_slug' => Str::slug($request->category_name, '-'),
            'image' => $save_url
        ]);

        $notification = array(
            'message' => 'SubCategory Added Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('subcategory.all')->with($notification);
    }
    public function EditSubCategory($slug)
    {
        $categories = Category::latest()->get();
        $subcategory = SubCategory::where('category_slug', $slug)->firstOrFail();
       return view('admin.backend.subcategory.edit_dubcategory',compact('categories','subcategory')); 
    }

    public function UpdateSubCategory(Request $request ,$id){
        $request->validate([
            'category_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',


        ], [
            'category_name.required' => 'Please Enter SubCategory Name',
            'category_id.required' => 'Please Select Category',
            'category_id.exists' => 'Selected Category does not exist',
        ]);
        $subcategory = SubCategory::findOrFail($id);

        if ($request->file('image')) {
            // Remove the old image if it exists
            if (File::exists($subcategory->image)) {
                File::delete($subcategory->image);
            }
            // Path where you want to save the image
            $savePath = 'upload/subcategory_images';
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::read($image)->resize(370, 246)->save($savePath . '/' . $name_gen);
            $save_url = $savePath . '/' . $name_gen;

            $subcategory->update([
                'category_name' => $request->category_name,
                'category_slug' => Str::slug($request->category_name, '-'),
                'category_id' => $request->category_id,
                'image' => $save_url
            ]);
            $notification = array(
                'message' => 'SubCategory Updated with image Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('subcategory.all')->with($notification);
        } else {

            $subcategory->update([
                'category_name' => $request->category_name,
                'category_slug' => Str::slug($request->category_name, '-'),
                'category_id' => $request->category_id,

            ]);
            $notification = array(
                'message' => 'SubCategory Updated Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('subcategory.all')->with($notification);
        } 
    }
    public function DeleteSubCategory($id){
        $subcategory = SubCategory::findOrFail($id);
        $img = $subcategory->image;
        unlink($img);

        $subcategory->delete();
        $notification = array(
            'message' => 'SubCategory Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('subcategory.all')->with($notification);

    }
}

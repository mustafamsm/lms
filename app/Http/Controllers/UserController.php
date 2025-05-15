<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    { 
            $categories = Category::with(['courses' => function($query) {
                $query->where('status', 1);
            }])->latest()->take(6)->get();
             $allCourses = Course::with('goals')->where('status', 1)->latest()->take(6)->get();
        return view('frontend.index',compact('categories','allCourses'));
    }

    public  function UserProfile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('frontend.dashboard.edit_profile', compact('profileData'));
    }
    public function UserProfileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'name' => 'required|max:255|unique:users,name,' . $id,
            'username' => 'max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'photo' => 'nullable|mimes:jpg,jpeg,png,gif|max:5120', // 5MB = 5120KB

        ]);


        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');

            // Delete the old photo if it exists
            if ($data->photo && File::exists(public_path('upload/user_images/' . $data->photo))) {
                File::delete(public_path('upload/user_images/' . $data->photo));
            }

            $filename = date('YmdHi') . '_' . $file->getClientOriginalName();

            // Ensure the directory exists
            if (!File::exists(public_path('upload/user_images'))) {
                File::makeDirectory(public_path('upload/user_images'), 0755, true);
            }

            // Move the uploaded file to the directory
            $file->move(public_path('upload/user_images'), $filename);
            $data->photo = $filename;
        }

        $notification = [
            'message' => 'User Profile Updated Successfully',
            'alert-type' => 'success'
        ];

        $data->save();

        return redirect()->back()->with($notification);
    }
    public function UserLogout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
    public function UserChangePassword(){

        return view('frontend.dashboard.change_password');
    }
    public function UserPasswordUpdate(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required|same:new_password',
        ]);
        if (Hash::check($request->old_password, Auth::user()->password)) {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->new_password);
            $user->save();
            $notification = array(
                'message' => 'Password Changed Successfully',
                'alert-type' => 'success'

            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Old Password Does Not Match',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}

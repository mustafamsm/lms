<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    public function index()
    {

        return view('admin.index');
    } //end of index

    public function logout(Request $request)
    {

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    } //end of logout

    public function login()
    {
        return view('admin.admin_login');
    }

    public function profile()
    {

        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_profile_view', compact('profileData'));
    }

    public function ProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $request->validate([
            'name' => 'required|max:255|unique:users,name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'photo' => 'mimes:jpg,jpeg,png,gif',
        ]);

        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();

            if (!File::exists(public_path('upload/instructor_images'))) {
                File::makeDirectory(public_path('upload/instructor_images'), 0755, true);
            }
            $data['photo'] = $filename;
        }
        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );
        $data->save();
        return redirect()->back()->with($notification);
    }
    public function ChangePassword()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('admin.admin_change_password', compact('profileData'));
    }
    public function passwordUpdate(Request $request)
    {
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

    public function BecomeInstructor()
    {
        return view('frontend.instructor.reg_instructor');
    }
    public function InstructorRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'phone' => 'required|string|max:255|unique:users,phone',
            'address' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',

        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'phone' => $request->phone,
            'address' => $request->address,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'instructor',
            'status' => '0',
        ]);

        $notification = array(
            'message' => 'Instructor Registration Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('instructor.login')->with($notification);
    }

    public function AllInstructor()
    {
        $instructors = User::where('role', 'instructor')->latest()->get();
        return view('admin..backend.instructor.all_instructor', compact('instructors'));
    }
    public function UpdateUserStatus(Request $request)
    {

        $user = User::find($request->user_id);

        $status = $request->input('status', 0);
        if ($user) {
            $user->status = $status;
            $user->save();
            return response()->json(['message' => 'Status updated successfully.']);
        } else {
            return response()->json(['error' => 'User not found.'], 404);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
    public function index()
    {
        return view('instructor.index');
    } //end of index

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/instructor/login');
    }

    public function login()
    {
        return view('instructor.instructor_login');
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('instructor.instructor_profile_view', compact('profileData'));
    }


    public function ProfileStore(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->username = $request->username;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('upload/instructor_images/' . $data->photo));
            $filename = date('YmdHi') . $file->getClientOriginalName();

            if (!File::exists(public_path('upload/instructor_images'))) {
                File::makeDirectory(public_path('upload/instructor_images'), 0755, true);
            }

            $file->move(public_path('upload/instructor_images'), $filename);
            $data['photo'] = $filename;
        }
        $data->save();
        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('instructor.profile')->with($notification);
    }

    public function ChangePassword()
    {
        $id = Auth::user()->id;
        $profileData = User::find($id);
        return view('instructor.instructor_change_password', compact('profileData'));
    }
    public function passwordUpdate(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
            'new_password_confirmation' => 'required|same:new_password',
         ]);
         if(Hash::check($request->old_password, Auth::user()->password)){
             $user = User::find(Auth::user()->id);
             $user->password = Hash::make($request->new_password);
             $user->save();
             $notification = array(
                 'message' => 'Password Changed Successfully',
                 'alert-type' => 'success'
                
             );
             return redirect()->back()->with($notification);
         }else{
             $notification = array(
                 'message' => 'Old Password Does Not Match',
                 'alert-type' => 'error'
             );
             return redirect()->back()->with($notification);
         }
    }
}

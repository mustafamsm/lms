<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function AddToWishList(Request $request, $id)
    {

        if (!Auth::check()) {
            return response()->json(['error' => 'Please login first.'], 401);
        }

        $course = Course::find($id);
        if (!$course) {
            return response()->json(['error' => 'Course not found.'], 404);
        }


        if (Auth::check()) {
            $exists = Wishlist::where('user_id', Auth::id())->where('course_id', $id)->first();
            if (!$exists) {
                Wishlist::create([
                    'user_id' => Auth::id(),
                    'course_id' => $id,
                ]);
                return response()->json(['success' => 'Added to wishlist.']);
            }
        }
        return response()->json(['info' => 'Already in wishlist.']);
    }

    public function AllWishlist()
    {
        $wishlists = Wishlist::with('course')->where('user_id', auth()->id())->get();

        return view('frontend.wishlist.all_wishlist', compact('wishlists'));
    }

 public function removeFromWishlist($id)
{
    $wishlist = Wishlist::where('user_id', Auth::id())->where('course_id', $id)->first();
    if ($wishlist) {
        $wishlist->delete();
        return response()->json(['success' => 'Removed from wishlist.']);
    }
    return response()->json(['error' => 'Not found in wishlist.'], 404);
}
}

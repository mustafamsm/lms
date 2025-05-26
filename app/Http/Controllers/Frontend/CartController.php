<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function AddToCart(Request $request, $id)
    {

        $course = Course::find($id);
        //check if the course is in the cart
        $cartItem = Cart::search(function ($cartItem, $rowId) use ($id) {
            return $cartItem->id === $id;
        });
        if ($cartItem->isNotEmpty()) {
            return response()->json(['error' => 'Course is already in your cart']);
        }
        // if ($course->discount_price !== null && $course->discount_price == $course->selling_price) {
        //     return response()->json(['error' => 'This course is free. Please enroll directly.']);
        // }
        // Determine the price to add to the cart using the effective_price accessor
        $priceToAddToCart = $course->effective_price;
         Cart::add([
            'id' => $id,
            'name' => $request->course_name,
            'qty' => 1,
            'price' => $priceToAddToCart, // Use the effective price
            'weight' => 1, // 'weight' is often unused for digital goods, keep if necessary
            'options' => [
                'image' => $course->course_image,
                'slug' => $request->course_name_slug,
                'instructor' => $request->instructor,
            ]
        ]);
        return response()->json(['success' => ' Successfully Added on your Cart']);
        
    }

    public function CartData()
    {
 
        $cartItems = Cart::content();
        $cartTotal = Cart::total();
        $cartCount = Cart::count();

        return response()->json([
            'cartItems' => $cartItems,
            'cartTotal' => $cartTotal,
            'cartCount' => $cartCount,
        ]);
    }
}

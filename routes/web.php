<?php

use App\Models\Course;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Backend\CourseController;
use App\Http\Controllers\Frontend\IndexController;
use App\Http\Controllers\Backend\CategoryController;
use App\Http\Controllers\Frontend\WishListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/', [UserController::class, 'index'])
    ->name('index');

Route::get('/dashboard', function () {
    return view('frontend.dashboard.index');
})->middleware(['auth', 'verified', 'roles:user'])->name('dashboard');


Route::middleware(['auth', 'roles:user'])->group(function () {
    Route::get('/user/profile', [UserController::class, 'UserProfile'])
        ->name('user.profile');
    Route::post('/user/profile/update', [UserController::class, 'UserProfileUpdate'])
        ->name('user.profile.update');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])
        ->name('user.logout');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])
        ->name('user.change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])
        ->name('user.password.update');

    Route::get('user/wishlist', [WishListController::class, 'AllWishlist'])->name('user.wishlist');
    Route::delete('remove-from-wishlist/{id}', [WishListController::class, 'removeFromWishlist']);
});


require __DIR__ . '/auth.php';


// Admin Routes
Route::middleware(['auth', 'roles:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])
        ->name('admin.dashboard');
    Route::get('/admin.logout', [AdminController::class, 'logout'])
        ->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'profile'])
        ->name('admin.profile');
    Route::post('/admin/profile/store', [AdminController::class, 'ProfileStore'])
        ->name('admin.profile.store');

    Route::get('/admin/change/password', [AdminController::class, 'ChangePassword'])
        ->name('admin.change.password');
    Route::put('/admin/password/update', [AdminController::class, "passwordUpdate"])
        ->name('admin.password.update');

    //category all routes

    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category/all', 'index')->name('category.all');
        Route::get('/category/add', 'create')->name('category.add');
        Route::post('/category/store', 'store')->name('category.store');
        Route::get('/category/edit/{slug}', 'edit')->name('category.edit');
        Route::put('/category/update/{id}', 'update')->name('category.update');
        Route::delete('/category/delete/{id}', 'destroy')->name('category.delete');
    });
    //subcategory routes
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/subcategory/all', 'AllSubCategory')->name('subcategory.all');
        Route::get('/subcategory/add', 'AddSubCategory')->name('subcategory.add');
        Route::post('/subcategory/store', 'StoreSubCategory')->name('subcategory.store');
        Route::get('/subcategory/edit/{slug}', 'EditSubCategory')->name('subcategory.edit');
        Route::put('/subcategory/update/{id}', 'UpdateSubCategory')->name('subcategory.update');
        Route::delete('/subcategory/delete/{id}', 'DeleteSubCategory')->name('subcategory.delete');
    });

    //instructor all routes
    Route::controller(AdminController::class)->group(function () {
        Route::get('/all/instructor', 'AllInstructor')->name('all.instructor');
        Route::post('/update/user/status', 'UpdateUserStatus')
            ->name('update.user.status');
    });
});
Route::get('/admin/login', [AdminController::class, 'login'])
    ->name('admin.login');


// Instructor Routes
Route::middleware(['auth', 'roles:instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorController::class, 'index'])
        ->name('instructor.dashboard');

    Route::get('/instructor/logout', [InstructorController::class, 'logout'])
        ->name('instructor.logout');

    Route::get('/instructor/profile', [InstructorController::class, 'profile'])
        ->name('instructor.profile');
    Route::post('/instructor/profile/store', [InstructorController::class, 'ProfileStore'])
        ->name('instructor.profile.store');

    Route::get('/instructor/change/password', [InstructorController::class, 'ChangePassword'])
        ->name('instructor.change.password');
    Route::post('/instructor/password/update', [InstructorController::class, "passwordUpdate"])
        ->name('instructor.password.update');

    Route::controller(CourseController::class)->group(function () {
        Route::get('/all/course', 'index')->name('all.course');
        Route::get('/add/course', 'create')->name('add.course');
        Route::post('/store/course', 'store')->name('store.course');
        Route::get('/edit/course/{id}', 'edit')->name('edit.course');
        Route::put('/update/course/{id}', 'update')->name('update.course');
        Route::delete('/course/{id}', 'destroy')->name('delete.course');

        Route::put('/update/course/image/{id}', 'updateCourseImage')
            ->name('update.course.image');
        Route::put('/update/course/video/{id}', 'updateCourseVideo')
            ->name('update.course.video');
        Route::put('/update/course/goals/{id}', 'updateCourseGoal')
            ->name('update.course.goals');

        //for course goals ajax update
        Route::put('/goals/{id}', [CourseController::class, 'updateGoal'])->name('update.goal');


        Route::get('/subcategory/ajax/{category_id}', 'GetSubCategory')->name('get.subcategory');
    });
    //course lecture routes
    Route::controller(CourseController::class)->group(function () {
        Route::get('/course/lecture/add/{id}', 'AddLecture')->name('add.course.lecture');
        Route::post('/course/lecture/store', 'StoreLecture')->name('store.course.lecture');
        Route::post('/course/section/{id}', 'StoreSection')->name('add.course.section');
        Route::post('/course/{course_id}/section/{section_id}/lecture', 'StoreLecture')
            ->name('store.course.lecture');
        Route::get('/lecture/edit/{id}', 'EditLecture')
            ->name('edit.lecture');
        Route::put('/lecture/update/{id}', 'UpdateLecture')
            ->name('update.lecture');
        Route::delete('/lecture/delete/{id}', 'DeleteLecture')
            ->name('delete.lecture');
        Route::delete('/section/delete/{id}', 'DeleteSection')
            ->name('delete.section');
    });
}); // end instructor routes group middleware

//home page routes
Route::get('/instructor/login', [InstructorController::class, 'login'])
    ->name('instructor.login');
Route::get('/course/details/{id}/{slug}', [IndexController::class, 'CourseDetails']);
Route::get('/category/courses/{slug}', [IndexController::class, 'CategoryCourse'])->name('category.details');
Route::get('/subcategory/courses/{slug}', [IndexController::class, 'SubCategoryCourse'])->name('subcategory.details');
Route::get('/instructor/details/{instructor}', [IndexController::class, 'InstructorDetails'])->name('instructor.details');
//wishlist ajax route
Route::post('/add-to-wishlist/{id}', [WishListController::class, 'AddToWishList']);
Route::get('/become/instructor', [AdminController::class, 'BecomeInstructor'])
    ->name('become.instructor');
Route::post('/instructor/register', [AdminController::class, 'InstructorRegister'])
    ->name('instructor.register');

//cart routes
Route::post('/cart/data/store/{id}', [CartController::class, 'AddToCart']);
Route::get('/course/mini/cart', [CartController::class, 'AddMiniCart'])->name('mini.cart');
Route::delete('/minicart/course/remove/{rowId}', [CartController::class, 'RemoveMiniCart'])->name('mini.cart.remove');
Route::get('/mycart', [CartController::class, 'MyCart'])->name('mycart');
Route::get('/get-cart-course',[CartController::class,'GetCartCourse']);
Route::delete('/cart-remove/{rowId}',[cartController::class,'CartRemove']);
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'course_title',
        'category_id',
        'subcategory_id',
        'course_image',
        'video',
        'selling_price',
        'discount_price',
        'duration',
        'resources',
        'label',
        'prerequisites',
        'description',
        'bestseller',
        'featured',
        'highestreated',
        'status',
        'certificate',
    ];
   
public function goals(){
    return $this->hasMany(Course_Goal::class,'course_id','id');
}


}

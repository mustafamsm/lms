<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'instructore_id'
    ];

    protected static function booted(){
        static::addGlobalScope('active',function(Builder $builder){
            $builder->where('status',1);
        });
    }
    public function goals()
    {
        return $this->hasMany(Course_Goal::class, 'course_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcategory_id', 'id');
    }
    public function sections()
    {
        return $this->hasMany(CourseSection::class, 'course_id', 'id');
    }
    public function lectures()
    {
        return $this->hasMany(CourseLecture::class, 'course_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class,'instructor_id','id');
    }
    

}

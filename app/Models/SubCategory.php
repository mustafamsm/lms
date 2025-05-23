<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = ['category_id', 'category_name', 'category_slug', 'image'];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function courses(){
        return $this->hasMany(Course::class,'subcategory_id','id');
    }
}

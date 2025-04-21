<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_name',
        'category_slug',
        'image',
    ];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
    protected static function booted()
    {
        static::deleting(function ($category) {
            
            // Delete subcategory images
            foreach ($category->subcategories as $sub) {
                if ($sub->image && file_exists($sub->image)) {
                    unlink($sub->image);
                }
            }
        });
    }
}

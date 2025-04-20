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

    public function getImageUrlAttribute()
    {
      
        // Check if the photo attribute is null or empty
        if (!$this->photo) {
            return asset('upload/no_image.jpg');
        }

        // Check if the file exists in the specified path
        if (!file_exists(public_path("upload/category_images/" . $this->photo))) {
            return asset('upload/no_image.jpg');
        }

        return asset("upload/category_images/" . $this->photo);
    } //end of getImageAttribute
    
}

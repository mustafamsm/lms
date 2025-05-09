<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLecture extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_id',
        'section_id',
        'lecture_title',
        'video',
        'url',
        'content',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }
    public function section()
    {
        return $this->belongsTo(CourseSection::class, 'section_id', 'id');
    }
}

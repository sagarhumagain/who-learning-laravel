<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseCategory;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'credit_hours',
        'url',
        'due_date',
    ];

    public function course_categories() {
        return $this->belongsToMany(CourseCategory::class, 'course_course_categories');
    }
}

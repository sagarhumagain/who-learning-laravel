<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCourseCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
      'course_id',
      'course_category_id'
    ];
}

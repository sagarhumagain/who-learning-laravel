<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
class CourseCourseCategory extends Model implements Auditable
{
    use HasFactory, AuditableTrait;
    protected $table = 'course_course_category';
    protected $guarded = [];
    protected $fillable = [
      'course_id',
      'course_category_id'
    ];
}

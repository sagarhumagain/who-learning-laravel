<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseCategory;
use App\Models\Employee;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
class Course extends Model implements Auditable
{
  use HasFactory, AuditableTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'credit_hours',
        'url',
        'source',
        'due_date',
        'is_approved'
    ];

    // protected $dates = ['due_date'];

    public function course_categories() {
        return $this->belongsToMany(CourseCategory::class, 'course_course_category');
    }

    public function employees() {
      return $this->belongsToMany(Employee::class, 'employee_course');
    }
}

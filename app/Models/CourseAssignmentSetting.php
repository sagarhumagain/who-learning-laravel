<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class CourseAssignmentSetting extends Model implements Auditable
{
    use HasFactory, AuditableTrait;
    protected $guarded = [];
    protected $fillable= [
      'course_id',
      'department_ids',
      'pillar_ids',
      'contract_type_ids',
      'staff_type_ids',
      'staff_designation_ids',
      'user_ids',
      'assignment_type',
      'assigned_by_user_id'
    ];
    protected $casts = [
      'department_ids' => 'array',
      'pillar_ids' => 'array',
      'contract_type_ids' => 'array',
      'staff_type_ids' => 'array',
      'staff_designation_ids' => 'array',
      'user_ids' => 'array'
    ];
}

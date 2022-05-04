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
      'department_ids',
      'pillar_ids',
      'contract_type_ids',
      'staff_type_ids',
      'staff_designation_ids',
      'user_ids',
      'assignment_type'
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

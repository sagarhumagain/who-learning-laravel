<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Designation;
use App\Models\StaffType;
class DesignationStaffType extends Model
{
    use HasFactory;
    protected $table = 'designation_staff_type';
    protected $guarded = [];
    protected $fillable = [
      'designation_id',
      'staff_type_id',
    ];
}

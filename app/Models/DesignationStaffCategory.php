<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Designation;
use App\Models\StaffCategory;
class DesignationStaffCategory extends Model
{
    use HasFactory;
    protected $table = 'designation_staff_category';
    protected $guarded = [];
    protected $fillable = [
      'designation_id',
      'staff_category_id',
    ];
}

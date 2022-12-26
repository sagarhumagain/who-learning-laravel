<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffCategoryStaffType extends Model
{
    use HasFactory;
    protected $table = 'staff_category_staff_type';
    protected $guarded = [];
    protected $fillable = [
      'staff_type_id',
      'staff_category_id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesignationStaffCategory extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
      'designation_id',
      'staff_category_id',
    ];
}

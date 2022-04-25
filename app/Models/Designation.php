<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StaffCategory;
use App\Models\StaffType;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function staff_categories() {
        return $this->belongsToMany(StaffCategory::class, 'designation_staff_categories');
    }

    public function staff_types() {
        return $this->belongsToMany(StaffType::class, 'designation_staff_types');
    }
}

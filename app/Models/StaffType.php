<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Designation;

class StaffType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function designations() {
        return $this->belongsToMany(Designation::class, 'designation_staff_types');
    }
}

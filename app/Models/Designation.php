<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StaffCategory;
use App\Models\StaffType;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
class Designation extends Model implements Auditable
{
    use HasFactory, AuditableTrait;

    protected $fillable = [
        'name',
        'description',
    ];

    public function staff_categories() {
        return $this->belongsToMany(StaffCategory::class, 'designation_staff_category');
    }

    public function staff_types() {
        return $this->belongsToMany(StaffType::class, 'designation_staff_type');
    }
}

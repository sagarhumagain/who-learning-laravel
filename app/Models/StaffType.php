<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Designation;
use App\Models\Contract;
use App\Models\ContractType;
use App\Models\StaffCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
class StaffType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;

    protected $fillable = [
        'name',
        'description',
        'slug'
    ];

    public function contracts() {
      return $this->hasMany(Contract::class, 'staff_type_id');
    }

    public function designations() {
      return $this->belongsToMany(Designation::class, 'designation_staff_type');
    }

    public function contractTypes() {
      return $this->belongsToMany(ContractType::class, 'designation_staff_type');
    }

    public function staffCategories() {
      return $this->belongsToMany(StaffCategory::class, 'staff_category_staff_type');
    }
}

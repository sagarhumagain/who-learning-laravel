<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contract;
use App\Models\ContractType;
use App\Models\StaffCategory;
use App\Models\StaffType;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Designation extends Model implements Auditable
{
    use HasFactory, AuditableTrait, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    public function contracts() {
      return $this->hasMany(Contract::class, 'designation_id');
    }

    public function contractTypes() {
      return $this->belongsToMany(ContractType::class, 'contract_type_designation');
    }

    public function staffCategories() {
        return $this->belongsToMany(StaffCategory::class, 'designation_staff_category');
    }

    public function staffTypes() {
        return $this->belongsToMany(StaffType::class, 'designation_staff_type');
    }
}

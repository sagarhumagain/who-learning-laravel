<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Models\Contract;
use App\Models\Designation;
use App\Models\StaffCategory;
class ContractType extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;

    protected $fillable = [
        'name',
        'description',
        'slug'
    ];

    public function contracts() {
      return $this->hasMany(Contract::class, 'contract_type_id');
    }

    public function designations() {
      return $this->belongsToMany(Designation::class, 'contract_type_designation');
    }

    public function staffCategories() {
      return $this->belongsToMany(StaffCategory::class, 'contract_type_staff_category');
    }

    public function staffTypes() {
      return $this->belongsToMany(StaffTypes::class, 'contract_type_staff_type');
    }
}

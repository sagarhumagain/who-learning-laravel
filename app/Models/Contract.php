<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Models\ContractType;
use App\Models\Designation;
use App\Models\StaffCategory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;

    protected $fillable = [
        'contract_start',
        'contract_end',
        'contract_type_id',
        'user_id',
        'designation_id',
        'is_active',
        'staff_category_id',
        'staff_type_id'
    ];

    public function contractType() {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }

    public function designation() {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function staffCategory() {
        return $this->belongsTo(StaffCategory::class, 'staff_category_id');
    }

    public function staffType() {
      return $this->belongsTo(StaffType::class, 'staff_type_id');
  }

}

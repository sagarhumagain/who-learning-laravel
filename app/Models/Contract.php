<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Models\ContractType;
use App\Models\Designation;
use App\Models\StaffCategory;

class Contract extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'contract_start',
        'contract_end',
        'contract_type_id',
        'user_id',
        'designation_id',
        'is_active',
        'staff_category_id',
    ];

    public function contract_types() {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }

    public function designations() {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    public function staff_categories() {
        return $this->belongsTo(StaffCategory::class, 'staff_category_id');
    }

}

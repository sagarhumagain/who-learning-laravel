<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Designation;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Models\Contract;
class StaffCategory extends Model  implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;

    protected $fillable = [
        'name',
        'description',
        'slug'
    ];

    public function designations() {
        return $this->belongsToMany(Designation::class, 'designation_staff_category');
    }

    public function contracts() {
      return $this->hasMany(Contract::class, 'staff_category_id');
    }
}

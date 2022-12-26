<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractTypeStaffCategory extends Model
{
    use HasFactory;
    protected $table = 'contract_type_staff_category';
    protected $guarded = [];
    protected $fillable = [
      'contract_type_id',
      'staff_category_id',
    ];
}

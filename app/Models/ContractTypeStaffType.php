<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractTypeStaffType extends Model
{
    use HasFactory;
    protected $table = 'contract_type_staff_type';
    protected $guarded = [];
    protected $fillable = [
      'contract_type_id',
      'staff_type_id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Designation;
use App\Models\StaffCategory;
class ContractTypeDesignation extends Model
{
    use HasFactory;
    protected $table = 'contract_type_designation';
    protected $guarded = [];
    protected $fillable = [
      'contract_type_id',
      'designation_id',
    ];
}

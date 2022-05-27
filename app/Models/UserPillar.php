<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class UserPillar extends Model implements Auditable
{
    use HasFactory, AuditableTrait;
    protected $table = 'pillar_user';
    protected $guarded = [];
    protected $fillable = [
      'user_id',
      'pillar_id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Models\User;

class Employee extends Model implements Auditable
{
    use HasFactory, AuditableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'primary_contact',
      'secondary_contact',
      'profile',
      'user_id',
      'supervisor_user_id',
      'address',
      'signature',
      'emp_code'
  ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [

  ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [

  ];

    /**
     * Get the user of employee.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the supervisor associated with the user.
     */
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_user_id');
    }
}

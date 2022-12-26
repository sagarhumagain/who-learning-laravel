<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class CourseUser extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;
    protected $table = 'course_user';
    protected $guarded = [];
    protected $fillable = [
      'user_id',
      'course_id',
      'certificate_path',
      'completed_date',
      'is_approved'
    ];
}

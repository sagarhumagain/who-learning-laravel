<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CourseCategory;
use App\Models\User;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Course extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'credit_hours',
        'url',
        'source',
        'due_date',
        'is_approved',
        'remarks',
    ];

    // protected $dates = ['due_date'];

    public function courseCategories()
    {
        return $this->belongsToMany(CourseCategory::class, 'course_course_category');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('completed_date', 'certificate_path', 'is_approved')->wherePivotNull('deleted_at');
    }
    public function courseAssignment()
    {
        return $this->hasOne(CourseAssignmentSetting::class, 'course_id', 'id');
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where(DB::raw('UPPER(name)'), 'LIKE', DB::raw("UPPER('%{$search}%')"))
                    ->orWhere(DB::raw('UPPER(url)'), 'LIKE', DB::raw("UPPER('%{$search}%')"))
                    ->orWhere(DB::raw('UPPER(source)'), 'LIKE', DB::raw("UPPER('%{$search}%')"))
                    ->orWhereHas('courseCategories', function ($q) use ($search) {
                        $q->where(DB::raw('UPPER(name)'), 'LIKE', DB::raw("UPPER('%{$search}%')"));
                    });
            });
        });
    }
}

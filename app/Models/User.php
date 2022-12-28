<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Models\Employee;
use App\Models\Course;
use App\Models\Pillar;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements Auditable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasRoles;
    use AuditableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard_name = 'api';

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_first_time_login'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the employee associated with the user.
     */
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    public function pillars()
    {
        return $this->belongsToMany(Pillar::class, 'pillar_user');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withPivot('completed_date', 'certificate_path', 'is_approved');
    }


    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}

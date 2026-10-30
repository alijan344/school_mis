<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $primaryKey = 'staff_id';

    public $timestamps = false;

    protected $fillable = [
        'firstname',
        'lastname',
        'fathername',
        'gender',
        'birth_year',
        'photo',
        'nic',
        'phone',
        'email',
        'province',
        'district',
        'village',
        'current_address',
        'position',
        'gross_salary',
        'status',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'staff_id', 'staff_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(StaffAttendance::class, 'staff_id', 'staff_id');
    }

    public function documents(): HasMany
    {
        return $this->hasMany(StaffDocument::class, 'staff_id', 'staff_id');
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(StaffSalary::class, 'staff_id', 'staff_id');
    }
}
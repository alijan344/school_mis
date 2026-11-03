<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teacher';

    protected $primaryKey = 'teacher_id';

    public $timestamps = false;

    protected $fillable = [
        'firstname',
        'lastname',
        'fathername',
        'gender',
        'birth_year',
        'photo',
        'phone',
        'email',
        'province',
        'district',
        'village',
        'current_address',
        'education_degree',
        'education_field',
        'education_university',
        'education_year',
        'talent_score',
        'gross_salary',
        'hod_bonus',
        'academic_bonus',
        'food_charge',
        'talent_bonus',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'teacher_id' => 'integer',
            'gender' => 'boolean',
            'birth_year' => 'integer',
            'education_year' => 'integer',
            'talent_score' => 'integer',
            'gross_salary' => 'integer',
            'hod_bonus' => 'integer',
            'academic_bonus' => 'integer',
            'food_charge' => 'integer',
            'talent_bonus' => 'integer',
            'status' => 'boolean',
        ];
    }

    // Approximate age accessor
    protected function age(): Attribute
    {
        return Attribute::get(function (): ?int {
            if (!$this->birth_year) {
                return null;
            }

            return max(0, now()->year - (int) $this->birth_year);
        });
    }

    // Filter by status
    public function scopeStatus(Builder $query, int|string $status): Builder
    {
        return $query->where('status', $status);
    }

    // Search teachers
    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function (Builder $inner) use ($term) {
            $inner->where('firstname', 'like', "%{$term}%")
                ->orWhere('lastname', 'like', "%{$term}%")
                ->orWhere('fathername', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%")
                ->orWhere('education_field', 'like', "%{$term}%");
        });
    }

    public function documents()
    {
        return $this->hasMany(
            TeacherDocument::class,
            'teacher_id',
            'teacher_id'
        );
    }

    public function attendances()
    {
        return $this->hasMany(
            TeacherAttendance::class,
            'teacher_id',
            'teacher_id'
        );
    }

    public function salaries()
    {
        return $this->hasMany(
            TeacherSalary::class,
            'teacher_id',
            'teacher_id'
        );
    }

    public function timetables()
    {
        return $this->hasMany(
            Timetable::class,
            'teacher_id',
            'teacher_id'
        );
    }
}
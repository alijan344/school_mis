<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

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

    protected function casts(): array
    {
        return [
            'staff_id' => 'integer',
            'gender' => 'boolean',
            'birth_year' => 'integer',
            'gross_salary' => 'integer',
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

    // Search staff
    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function (Builder $inner) use ($term) {
            $inner->where('firstname', 'like', "%{$term}%")
                ->orWhere('lastname', 'like', "%{$term}%")
                ->orWhere('fathername', 'like', "%{$term}%")
                ->orWhere('phone', 'like', "%{$term}%")
                ->orWhere('email', 'like', "%{$term}%");
        });
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'staff_id', 'staff_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(
            StaffAttendance::class,
            'staff_id',
            'staff_id'
        );
    }

    public function documents(): HasMany
    {
        return $this->hasMany(
            StaffDocument::class,
            'staff_id',
            'staff_id'
        );
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(
            StaffSalary::class,
            'staff_id',
            'staff_id'
        );
    }
}
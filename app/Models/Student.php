<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'student';

    protected $primaryKey = 'student_id';

    public $timestamps = false;

    protected $fillable = [
        'reg_no',
        'firstname',
        'fathername',
        'grandfathername',
        'gender',
        'birth_year',
        'province',
        'district',
        'current_address',
        'nic',
        'phone',
        'photo',
        'status',
        'section_id',
    ];

    protected function casts(): array
    {
        return [
            'student_id' => 'integer',
            'gender' => 'boolean',
            'birth_year' => 'integer',
            'status' => 'integer',
            'section_id' => 'integer',
        ];
    }

    public function classSection()
    {
        return $this->belongsTo(
            ClassSection::class,
            'section_id',
            'section_id'
        );
    }

    public function relatives()
    {
        return $this->hasMany(
            StudentRelative::class,
            'student_id',
            'student_id'
        );
    }

    public function transfers()
    {
        return $this->hasMany(
            StudentTransfer::class,
            'student_id',
            'student_id'
        );
    }

    public function documents()
    {
        return $this->hasMany(
            StudentDocument::class,
            'student_id',
            'student_id'
        );
    }

    public function attendances()
    {
        return $this->hasMany(
            StudentAttendance::class,
            'student_id',
            'student_id'
        );
    }
}
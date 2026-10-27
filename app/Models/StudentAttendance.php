<?php

namespace App\Models;

use App\Models\Concerns\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory, HasCompositePrimaryKey;

    protected $table = 'student_attendance';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'absent_date',
        'absent_type',
    ];

    protected function casts(): array
    {
        return [
            'student_id' => 'integer',
            'absent_date' => 'date',
            'absent_type' => 'integer',
        ];
    }

    protected function getCompositeKeyColumns(): array
    {
        return [
            'student_id',
            'absent_date',
        ];
    }

    public function student()
    {
        return $this->belongsTo(
            Student::class,
            'student_id',
            'student_id'
        );
    }
}
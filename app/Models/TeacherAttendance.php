<?php

namespace App\Models;

use App\Models\Concerns\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAttendance extends Model
{
    use HasFactory, HasCompositePrimaryKey;

    protected $table = 'teacher_attendance';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'teacher_id',
        'absent_year',
        'absent_month',
        'absent_day',
        'remark',
    ];

    protected function casts(): array
    {
        return [
            'teacher_id' => 'integer',
            'absent_year' => 'integer',
            'absent_month' => 'integer',
            'absent_day' => 'integer',
        ];
    }

    protected function getCompositeKeyColumns(): array
    {
        return [
            'teacher_id',
            'absent_year',
            'absent_month',
            'absent_day',
        ];
    }

    public function teacher()
    {
        return $this->belongsTo(
            Teacher::class,
            'teacher_id',
            'teacher_id'
        );
    }
}
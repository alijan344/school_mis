<?php

namespace App\Models;

use App\Models\Concerns\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timetable extends Model
{
    use HasFactory, HasCompositePrimaryKey;

    protected $table = 'timetable';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'weekday',
        'lesson_hour',
        'teacher_id',
        'subject_id',
        'section_id',
    ];

    protected function casts(): array
    {
        return [
            'weekday' => 'integer',
            'lesson_hour' => 'integer',
            'teacher_id' => 'integer',
            'subject_id' => 'integer',
            'section_id' => 'integer',
        ];
    }

    protected function getCompositeKeyColumns(): array
    {
        return [
            'weekday',
            'lesson_hour',
            'teacher_id',
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

    public function subject()
    {
        return $this->belongsTo(
            Subject::class,
            'subject_id',
            'subject_id'
        );
    }

    public function classSection()
    {
        return $this->belongsTo(
            ClassSection::class,
            'section_id',
            'section_id'
        );
    }
}
<?php

namespace App\Models;

use App\Models\Concerns\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory, HasCompositePrimaryKey;

    protected $table = 'score';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'subject_id',
        'exam_year',
        'section_id',
        'mid_exam',
        'final_exam',
        'second_chance',
        'total_mark',
    ];

    protected function casts(): array
    {
        return [
            'student_id' => 'integer',
            'subject_id' => 'integer',
            'exam_year' => 'integer',
            'section_id' => 'integer',
            'mid_exam' => 'integer',
            'final_exam' => 'integer',
            'second_chance' => 'integer',
            'total_mark' => 'integer',
        ];
    }

    protected function getCompositeKeyColumns(): array
    {
        return [
            'student_id',
            'subject_id',
            'exam_year',
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
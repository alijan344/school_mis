<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSection extends Model
{
    use HasFactory;

    protected $table = 'class_section';

    protected $primaryKey = 'section_id';

    public $timestamps = false;

    protected $fillable = [
        'section_name',
        'class_id',
    ];

    protected function casts(): array
    {
        return [
            'section_id' => 'integer',
            'class_id' => 'integer',
        ];
    }

    public function schoolClass()
    {
        return $this->belongsTo(
            Classes::class,
            'class_id',
            'class_id'
        );
    }

    public function students()
    {
        return $this->hasMany(
            Student::class,
            'section_id',
            'section_id'
        );
    }

    public function timetables()
    {
        return $this->hasMany(
            Timetable::class,
            'section_id',
            'section_id'
        );
    }

    public function scores()
    {
        return $this->hasMany(
            Score::class,
            'section_id',
            'section_id'
        );
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subject';

    protected $primaryKey = 'subject_id';

    public $timestamps = false;

    protected $fillable = [
        'subject_name',
    ];

    protected function casts(): array
    {
        return [
            'subject_id' => 'integer',
        ];
    }

    public function timetables()
    {
        return $this->hasMany(
            Timetable::class,
            'subject_id',
            'subject_id'
        );
    }

    public function scores()
    {
        return $this->hasMany(
            Score::class,
            'subject_id',
            'subject_id'
        );
    }
}
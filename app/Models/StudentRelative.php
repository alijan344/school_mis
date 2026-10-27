<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentRelative extends Model
{
    use HasFactory;

    protected $table = 'student_relative';

    protected $primaryKey = 'relative_id';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'relative_name',
        'relative_phone',
        'relative_relation',
    ];

    protected function casts(): array
    {
        return [
            'relative_id' => 'integer',
            'student_id' => 'integer',
        ];
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibMember extends Model
{
    use HasFactory;

    protected $table = 'lib_member';

    protected $primaryKey = 'student_id';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'reg_date',
    ];

    protected function casts(): array
    {
        return [
            'student_id' => 'integer',
            'reg_date' => 'date',
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

    public function loans()
    {
        return $this->hasMany(
            LibLoan::class,
            'student_id',
            'student_id'
        );
    }
}
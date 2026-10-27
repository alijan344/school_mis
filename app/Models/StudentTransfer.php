<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTransfer extends Model
{
    use HasFactory;

    protected $table = 'student_transfer';

    protected $primaryKey = 'transfer_id';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'transfer_date',
        'transfer_no',
        'school_name',
        'transfer_type',
    ];

    protected function casts(): array
    {
        return [
            'transfer_id' => 'integer',
            'student_id' => 'integer',
            'transfer_date' => 'date',
            'transfer_type' => 'boolean',
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
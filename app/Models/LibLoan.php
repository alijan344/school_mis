<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibLoan extends Model
{
    use HasFactory;

    protected $table = 'lib_loan';

    protected $primaryKey = 'loan_id';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'book_id',
        'loan_date',
        'return_date',
    ];

    protected function casts(): array
    {
        return [
            'loan_id' => 'integer',
            'student_id' => 'integer',
            'book_id' => 'integer',
            'loan_date' => 'date',
            'return_date' => 'date',
        ];
    }

    public function libMember()
    {
        return $this->belongsTo(
            LibMember::class,
            'student_id',
            'student_id'
        );
    }

    public function libBook()
    {
        return $this->belongsTo(
            LibBook::class,
            'book_id',
            'book_id'
        );
    }
}
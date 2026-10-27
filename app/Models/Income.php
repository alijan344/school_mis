<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $table = 'income';

    protected $primaryKey = 'income_id';

    public $timestamps = false;

    protected $fillable = [
        'source_id',
        'income_amount',
        'income_date',
        'student_id',
    ];

    protected function casts(): array
    {
        return [
            'income_id' => 'integer',
            'source_id' => 'integer',
            'income_amount' => 'integer',
            'income_date' => 'date',
            'student_id' => 'integer',
        ];
    }

    public function incomeSource()
    {
        return $this->belongsTo(
            IncomeSource::class,
            'source_id',
            'source_id'
        );
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
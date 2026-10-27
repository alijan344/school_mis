<?php

namespace App\Models;

use App\Models\Concerns\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherSalary extends Model
{
    use HasFactory, HasCompositePrimaryKey;

    protected $table = 'teacher_salary';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'teacher_id',
        'salary_year',
        'salary_month',
        'tax_amount',
        'absent_amount',
        'loan_amount',
        'non_absent_bonus',
        'bonus',
        'payable_salary',
        'guarantee',
        'net_salary',
        'pay_date',
    ];

    protected function casts(): array
    {
        return [
            'teacher_id' => 'integer',
            'salary_year' => 'integer',
            'salary_month' => 'integer',
            'tax_amount' => 'integer',
            'absent_amount' => 'integer',
            'loan_amount' => 'integer',
            'non_absent_bonus' => 'integer',
            'bonus' => 'integer',
            'payable_salary' => 'integer',
            'guarantee' => 'float',
            'net_salary' => 'integer',
            'pay_date' => 'date',
        ];
    }

    protected function getCompositeKeyColumns(): array
    {
        return [
            'teacher_id',
            'salary_year',
            'salary_month',
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
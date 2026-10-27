<?php

namespace App\Models;

use App\Models\Concerns\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSalary extends Model
{
    use HasFactory, HasCompositePrimaryKey;

    protected $table = 'staff_salary';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'staff_id',
        'salary_year',
        'salary_month',
        'absent_amount',
        'bonus',
        'tax_amount',
        'payable_salary',
        'guarantee',
        'net_salary',
        'pay_date',
    ];

    protected function casts(): array
    {
        return [
            'staff_id' => 'integer',
            'salary_year' => 'integer',
            'salary_month' => 'integer',
            'absent_amount' => 'integer',
            'bonus' => 'integer',
            'tax_amount' => 'integer',
            'payable_salary' => 'integer',
            'guarantee' => 'float',
            'net_salary' => 'integer',
            'pay_date' => 'date',
        ];
    }

    protected function getCompositeKeyColumns(): array
    {
        return [
            'staff_id',
            'salary_year',
            'salary_month',
        ];
    }

    public function staff()
    {
        return $this->belongsTo(
            Staff::class,
            'staff_id',
            'staff_id'
        );
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncomeSource extends Model
{
    use HasFactory;

    protected $table = 'income_source';

    protected $primaryKey = 'source_id';

    public $timestamps = false;

    protected $fillable = [
        'source_name',
    ];

    protected function casts(): array
    {
        return [
            'source_id' => 'integer',
        ];
    }

    public function incomes()
    {
        return $this->hasMany(Income::class, 'source_id', 'source_id');
    }

    public function otherIncomes()
    {
        return $this->hasMany(OtherIncome::class, 'source_id', 'source_id');
    }
}
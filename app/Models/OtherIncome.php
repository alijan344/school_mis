<?php

namespace App\Models;

use App\Models\Concerns\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherIncome extends Model
{
    use HasFactory, HasCompositePrimaryKey;

    protected $table = 'other_income';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'income_id',
        'source_id',
        'income_amount',
        'income_date',
    ];

    protected function casts(): array
    {
        return [
            'income_id' => 'integer',
            'source_id' => 'integer',
            'income_amount' => 'integer',
            'income_date' => 'date',
        ];
    }

    protected function getCompositeKeyColumns(): array
    {
        return [
            'income_id',
            'source_id',
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
}
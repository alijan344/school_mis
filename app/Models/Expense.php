<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $table = 'expense';

    protected $primaryKey = 'expense_id';

    public $timestamps = false;

    protected $fillable = [
        'account_id',
        'expense_amount',
        'expense_date',
        'remark',
    ];

    protected function casts(): array
    {
        return [
            'expense_id' => 'integer',
            'account_id' => 'integer',
            'expense_amount' => 'integer',
            'expense_date' => 'date',
        ];
    }

    public function chartofaccount()
    {
        return $this->belongsTo(
            Chartofaccount::class,
            'account_id',
            'account_id'
        );
    }
}
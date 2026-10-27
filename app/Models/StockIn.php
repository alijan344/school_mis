<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;

    protected $table = 'stock_in';

    protected $primaryKey = 'stock_in_id';

    public $timestamps = false;

    protected $fillable = [
        'stock_id',
        'in_date',
        'in_quantity',
        'remark',
    ];

    protected function casts(): array
    {
        return [
            'stock_in_id' => 'integer',
            'stock_id' => 'integer',
            'in_date' => 'date',
            'in_quantity' => 'float',
        ];
    }

    public function stock()
    {
        return $this->belongsTo(
            Stock::class,
            'stock_id',
            'stock_id'
        );
    }
}
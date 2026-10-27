<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    protected $primaryKey = 'stock_id';

    public $timestamps = false;

    protected $fillable = [
        'item_name',
        'unit',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'stock_id' => 'integer',
            'quantity' => 'float',
        ];
    }

    public function stockIns()
    {
        return $this->hasMany(
            StockIn::class,
            'stock_id',
            'stock_id'
        );
    }

    public function stockOuts()
    {
        return $this->hasMany(
            Stock::class,
            'stock_id',
            'stock_id'
        );
    }
}
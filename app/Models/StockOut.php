<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    use HasFactory;

    protected $table = 'stock_out';

    protected $primaryKey = 'stock_out_id';

    public $timestamps = false;

    protected $fillable = [
        'stock_id',
        'out_date',
        'out_quantity',
        'remark',
    ];

    protected function casts(): array
    {
        return [
            'stock_out_id' => 'integer',
            'stock_id' => 'integer',
            'out_date' => 'date',
            'out_quantity' => 'float',
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
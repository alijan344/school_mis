<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $table = 'purchase';

    protected $primaryKey = 'purchase_id';

    public $timestamps = false;

    protected $fillable = [
        'staff_id',
        'purchase_date',
        'item_name',
        'unit',
        'quantity',
        'unitprice',
        'totalprice',
    ];

    protected function casts(): array
    {
        return [
            'purchase_id' => 'integer',
            'staff_id' => 'integer',
            'purchase_date' => 'date',
            'quantity' => 'float',
            'unitprice' => 'integer',
            'totalprice' => 'integer',
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
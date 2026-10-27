<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chartofaccount extends Model
{
    use HasFactory;

    protected $table = 'chartofaccount';

    protected $primaryKey = 'account_id';

    public $timestamps = false;

    protected $fillable = [
        'account_name',
    ];

    protected function casts(): array
    {
        return [
            'account_id' => 'integer',
        ];
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class, 'account_id', 'account_id');
    }
}
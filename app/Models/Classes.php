<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $primaryKey = 'class_id';

    public $timestamps = false;

    protected $fillable = [
        'class_name',
        'fees',
    ];

    protected function casts(): array
    {
        return [
            'class_id' => 'integer',
            'fees' => 'integer',
        ];
    }

    public function sections()
    {
        return $this->hasMany(
            ClassSection::class,
            'class_id',
            'class_id'
        );
    }
}
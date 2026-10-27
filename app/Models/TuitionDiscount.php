<?php

namespace App\Models;

use App\Models\Concerns\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TuitionDiscount extends Model
{
    use HasFactory, HasCompositePrimaryKey;

    protected $table = 'tuition_discount';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'discount_year',
        'section_id',
        'discount_amount',
        'discount_type',
    ];

    protected function casts(): array
    {
        return [
            'student_id' => 'integer',
            'discount_year' => 'integer',
            'section_id' => 'integer',
            'discount_amount' => 'float',
            'discount_type' => 'boolean',
        ];
    }

    protected function getCompositeKeyColumns(): array
    {
        return [
            'student_id',
            'discount_year',
        ];
    }

    public function student()
    {
        return $this->belongsTo(
            Student::class,
            'student_id',
            'student_id'
        );
    }

    public function classSection()
    {
        return $this->belongsTo(
            ClassSection::class,
            'section_id',
            'section_id'
        );
    }
}
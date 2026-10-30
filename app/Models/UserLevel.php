<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserLevel extends Model
{
    use HasFactory;

    protected $table = 'user_level';

    protected $primaryKey = 'staff_id';

    public $incrementing = false;

    protected $keyType = 'int';

    public $timestamps = false;

    protected $fillable = [
        'staff_id',
        'admin_level',
        'academic_level',
        'student_level',
        'teacher_level',
        'staff_level',
        'finance_level',
        'library_level',
        'stock_level',
        'IT_level',
    ];

    protected function casts(): array
    {
        return [
            'staff_id' => 'integer',
            'admin_level' => 'integer',
            'academic_level' => 'integer',
            'student_level' => 'integer',
            'teacher_level' => 'integer',
            'staff_level' => 'integer',
            'finance_level' => 'integer',
            'library_level' => 'integer',
            'stock_level' => 'integer',
            'IT_level' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id', 'staff_id');
    }
}
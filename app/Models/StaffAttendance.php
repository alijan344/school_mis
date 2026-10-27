<?php

namespace App\Models;

use App\Models\Concerns\HasCompositePrimaryKey;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAttendance extends Model
{
    use HasFactory, HasCompositePrimaryKey;

    protected $table = 'staff_attendance';

    protected $primaryKey = null;

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'staff_id',
        'absent_year',
        'absent_month',
        'absent_day',
        'remark',
    ];

    protected function casts(): array
    {
        return [
            'staff_id' => 'integer',
            'absent_year' => 'integer',
            'absent_month' => 'integer',
            'absent_day' => 'integer',
        ];
    }

    protected function getCompositeKeyColumns(): array
    {
        return [
            'staff_id',
            'absent_year',
            'absent_month',
            'absent_day',
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
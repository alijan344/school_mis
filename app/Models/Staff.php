<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    use HasFactory;

    protected $table = 'staff';

    protected $primaryKey = 'staff_id';

    public $timestamps = false;

    protected $fillable = [
        'firstname',
        'lastname',
        'fathername',
        'gender',
        'birth_year',
        'photo',
        'nic',
        'phone',
        'email',
        'province',
        'district',
        'village',
        'current_address',
        'position',
        'gross_salary',
        'status',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'staff_id', 'staff_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $primaryKey = 'staff_id';

    protected $keyType = 'int';

    public $incrementing = false;

    public $timestamps = false;

    protected $fillable = [
        'staff_id',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'staff_id' => 'integer',
            'password' => 'hashed',
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

    public function userLevel()
    {
        return $this->hasOne(
            UserLevel::class,
            'staff_id',
            'staff_id'
        );
    }
}
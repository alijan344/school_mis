<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffDocument extends Model
{
    use HasFactory;

    protected $table = 'staff_document';

    protected $primaryKey = 'document_id';

    public $timestamps = false;

    protected $fillable = [
        'staff_id',
        'document_name',
        'document_file',
        'upload_date',
    ];

    protected function casts(): array
    {
        return [
            'document_id' => 'integer',
            'staff_id' => 'integer',
            'upload_date' => 'date',
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
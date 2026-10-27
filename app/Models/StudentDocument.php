<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentDocument extends Model
{
    use HasFactory;

    protected $table = 'student_document';

    protected $primaryKey = 'document_id';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'document_name',
        'document_file',
        'upload_date',
    ];

    protected function casts(): array
    {
        return [
            'document_id' => 'integer',
            'student_id' => 'integer',
            'upload_date' => 'date',
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
}
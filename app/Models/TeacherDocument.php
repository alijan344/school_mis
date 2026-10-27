<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherDocument extends Model
{
    use HasFactory;

    protected $table = 'teacher_document';

    protected $primaryKey = 'document_id';

    public $timestamps = false;

    protected $fillable = [
        'teacher_id',
        'document_name',
        'document_file',
        'upload_date',
    ];

    protected function casts(): array
    {
        return [
            'document_id' => 'integer',
            'teacher_id' => 'integer',
            'upload_date' => 'date',
        ];
    }

    public function teacher()
    {
        return $this->belongsTo(
            Teacher::class,
            'teacher_id',
            'teacher_id'
        );
    }
}
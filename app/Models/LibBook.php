<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibBook extends Model
{
    use HasFactory;

    protected $table = 'lib_book';

    protected $primaryKey = 'book_id';

    public $timestamps = false;

    protected $fillable = [
        'isbn',
        'book_name',
        'author',
        'publish_year',
        'publisher',
        'shelf',
        'shelf_row',
    ];

    protected function casts(): array
    {
        return [
            'book_id' => 'integer',
            'publish_year' => 'integer',
        ];
    }

    public function loans()
    {
        return $this->hasMany(LibLoan::class, 'book_id', 'book_id');
    }
}
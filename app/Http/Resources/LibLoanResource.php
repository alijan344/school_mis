<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LibLoanResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'loan_id' => $this->loan_id,
            'student_id' => $this->student_id,
            'book_id' => $this->book_id,
            'loan_date' => $this->loan_date,
            'return_date' => $this->return_date,

            'lib_member' => $this->whenLoaded(
                'libMember',
                fn () => [
                    'student_id' => $this->libMember->student_id,
                    'reg_date' => $this->libMember->reg_date,
                    'student' => $this->libMember->student
                        ? [
                            'student_id' => $this->libMember->student->student_id,
                            'firstname' => $this->libMember->student->firstname,
                            'fathername' => $this->libMember->student->fathername,
                        ]
                        : null,
                ]
            ),

            'lib_book' => $this->whenLoaded(
                'libBook',
                fn () => [
                    'book_id' => $this->libBook->book_id,
                    'book_name' => $this->libBook->book_name,
                    'author' => $this->libBook->author,
                    'isbn' => $this->libBook->isbn,
                ]
            ),
        ];
    }
}
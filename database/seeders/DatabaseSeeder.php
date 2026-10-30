<?php

namespace Database\Seeders;

use App\Models\Classes;
use App\Models\ClassSection;
use App\Models\Student;
use App\Models\StudentRelative;
use App\Models\StudentTransfer;
use App\Models\StudentDocument;
use App\Models\StudentAttendance;
use App\Models\Teacher;
use App\Models\TeacherDocument;
use App\Models\TeacherAttendance;
use App\Models\TeacherSalary;
use App\Models\Staff;
use App\Models\StaffDocument;
use App\Models\StaffAttendance;
use App\Models\StaffSalary;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\Score;
use App\Models\TuitionDiscount;
use App\Models\IncomeSource;
use App\Models\Income;
use App\Models\OtherIncome;
use App\Models\Chartofaccount;
use App\Models\Expense;
use App\Models\Purchase;
use App\Models\Stock;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\LibBook;
use App\Models\LibMember;
use App\Models\LibLoan;
use App\Models\User;
use App\Models\UserLevel;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Classes
        if (Classes::count() === 0) {
            Classes::factory(3)->create();
        }

        // 2. Class Sections
        if (ClassSection::count() === 0) {
            foreach (Classes::all() as $schoolClass) {
                ClassSection::factory(2)->create([
                    'class_id' => $schoolClass->class_id,
                ]);
            }
        }

        // 3. Students
        if (Student::count() === 0) {
            foreach (ClassSection::all() as $section) {
                Student::factory(2)->create([
                    'section_id' => $section->section_id,
                ]);
            }
        }

        // 4. Teachers
        if (Teacher::count() === 0) {
            Teacher::factory(5)->create();
        }

        // 5. Staff
        if (Staff::count() === 0) {
            Staff::factory(5)->create();
        }

        // 6. Subjects
        if (Subject::count() === 0) {
            Subject::factory(8)->create();
        }

        // 7. Income Sources
        if (IncomeSource::count() === 0) {
            IncomeSource::factory(3)->create();
        }

        // 8. Chart of Accounts
        if (Chartofaccount::count() === 0) {
            Chartofaccount::factory(5)->create();
        }

        // 9. Stock
        if (Stock::count() === 0) {
            Stock::factory(5)->create();
        }

        // 10. Library Books
        if (LibBook::count() === 0) {
            LibBook::factory(10)->create();
        }

        $students = Student::all();
        $teachers = Teacher::all();
        $staffMembers = Staff::all();
        $subjects = Subject::all();
        $sections = ClassSection::all();
        $incomeSources = IncomeSource::all();
        $accounts = Chartofaccount::all();
        $stocks = Stock::all();

        // 11. Student Related Data
        if (StudentRelative::count() === 0) {
            foreach ($students as $student) {
                StudentRelative::factory()->create([
                    'student_id' => $student->student_id,
                ]);
            }
        }

        if (StudentTransfer::count() === 0) {
            foreach ($students as $student) {
                StudentTransfer::factory()->create([
                    'student_id' => $student->student_id,
                ]);
            }
        }

        if (StudentDocument::count() === 0) {
            foreach ($students as $student) {
                StudentDocument::factory()->create([
                    'student_id' => $student->student_id,
                ]);
            }
        }

        if (StudentAttendance::count() === 0) {
            foreach ($students as $student) {
                StudentAttendance::factory()->create([
                    'student_id' => $student->student_id,
                ]);
            }
        }

        // 12. Teacher Related Data
        if (TeacherDocument::count() === 0) {
            foreach ($teachers as $teacher) {
                TeacherDocument::factory()->create([
                    'teacher_id' => $teacher->teacher_id,
                ]);
            }
        }

        if (TeacherAttendance::count() === 0) {
            foreach ($teachers as $teacher) {
                TeacherAttendance::factory()->create([
                    'teacher_id' => $teacher->teacher_id,
                ]);
            }
        }

        if (TeacherSalary::count() === 0) {
            foreach ($teachers as $teacher) {
                TeacherSalary::factory()->create([
                    'teacher_id' => $teacher->teacher_id,
                ]);
            }
        }

        // 13. Staff Related Data
        if (StaffDocument::count() === 0) {
            foreach ($staffMembers as $member) {
                StaffDocument::factory()->create([
                    'staff_id' => $member->staff_id,
                ]);
            }
        }

        if (StaffAttendance::count() === 0) {
            foreach ($staffMembers as $member) {
                StaffAttendance::factory()->create([
                    'staff_id' => $member->staff_id,
                ]);
            }
        }

        if (StaffSalary::count() === 0) {
            foreach ($staffMembers as $member) {
                StaffSalary::factory()->create([
                    'staff_id' => $member->staff_id,
                ]);
            }
        }

        // 14. Library Members
        if (LibMember::count() === 0) {
            foreach ($students as $student) {
                LibMember::factory()->create([
                    'student_id' => $student->student_id,
                ]);
            }
        }

        // 15. Library Loans
        if (LibLoan::count() === 0) {
            $members = LibMember::all();
            $books = LibBook::all();
            $book = $books->first();

            if ($book) {
                foreach ($members as $member) {
                    LibLoan::factory()->create([
                        'student_id' => $member->student_id,
                        'book_id' => $book->book_id,
                    ]);
                }
            }
        }

        // 16. Timetable
        if (Timetable::count() === 0 && $subjects->isNotEmpty() && $sections->isNotEmpty()) {
            foreach ($teachers as $index => $teacher) {
                Timetable::factory()->create([
                    'weekday' => ($index % 5) + 1,
                    'lesson_hour' => 1,
                    'teacher_id' => $teacher->teacher_id,
                    'subject_id' => $subjects[$index % $subjects->count()]->subject_id,
                    'section_id' => $sections[$index % $sections->count()]->section_id,
                ]);
            }
        }

        // 17. Student Scores
        if (Score::count() === 0 && $subjects->isNotEmpty()) {
            foreach ($students as $student) {
                Score::factory()->create([
                    'student_id' => $student->student_id,
                    'subject_id' => $subjects->first()->subject_id,
                    'section_id' => $student->section_id,
                ]);
            }
        }

        // 18. Tuition Discounts
        if (TuitionDiscount::count() === 0) {
            foreach ($students as $student) {
                TuitionDiscount::factory()->create([
                    'student_id' => $student->student_id,
                    'section_id' => $student->section_id,
                ]);
            }
        }

        // 19. Income
        if (Income::count() === 0 && $incomeSources->isNotEmpty()) {
            foreach ($students as $student) {
                Income::factory()->create([
                    'source_id' => $incomeSources->first()->source_id,
                    'student_id' => $student->student_id,
                ]);
            }
        }

        // 20. Other Income
        if (OtherIncome::count() === 0) {
            foreach ($incomeSources as $source) {
                OtherIncome::factory()->create([
                    'source_id' => $source->source_id,
                ]);
            }
        }

        // 21. Expenses
        if (Expense::count() === 0) {
            foreach ($accounts as $account) {
                Expense::factory()->create([
                    'account_id' => $account->account_id,
                ]);
            }
        }

        // 22. Purchases
        if (Purchase::count() === 0) {
            foreach ($staffMembers as $member) {
                Purchase::factory()->create([
                    'staff_id' => $member->staff_id,
                ]);
            }
        }

        // 23. Stock In
        if (StockIn::count() === 0) {
            foreach ($stocks as $stock) {
                StockIn::factory()->create([
                    'stock_id' => $stock->stock_id,
                ]);
            }
        }

        // 24. Stock Out
        if (StockOut::count() === 0) {
            foreach ($stocks as $stock) {
                StockOut::factory()->create([
                    'stock_id' => $stock->stock_id,
                ]);
            }
        }

        // 25. User Levels for Existing Users
        if (UserLevel::count() === 0) {
            foreach (User::all() as $user) {
                UserLevel::factory()->create([
                    'staff_id' => $user->staff_id,
                ]);
            }
        }
    }
}
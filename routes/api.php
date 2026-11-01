<?php


use Illuminate\Support\Facades\Route;

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassSectionController;
use App\Http\Controllers\ChartofaccountController;
use App\Http\Controllers\IncomeSourceController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\LibBookController;

use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentRelativeController;
use App\Http\Controllers\StudentTransferController;
use App\Http\Controllers\StudentDocumentController;
use App\Http\Controllers\StudentAttendanceController;

use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherDocumentController;
use App\Http\Controllers\TeacherAttendanceController;
use App\Http\Controllers\TeacherSalaryController;

use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffDocumentController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\StaffSalaryController;

use App\Http\Controllers\LibMemberController;
use App\Http\Controllers\LibLoanController;

use App\Http\Controllers\TimetableController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\TuitionDiscountController;

use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OtherIncomeController;

use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserLevelController;
use App\Http\Controllers\AuthController;

Route::prefix('v1')->group(function () {
// ==========================================
// Test API
// ==========================================

Route::get('/hello', [WelcomeController::class, 'hello']);

Route::get('/ping', function () {
    return response()->json([
        'pong' => true,
        'time' => now(),
    ]);
});



// ==========================================
// Classes CRUD API
// ==========================================

Route::apiResource('classes', ClassesController::class);


// ==========================================
// Class Sections CRUD API
// ==========================================

Route::apiResource('class-sections', ClassSectionController::class)
    ->parameters([
        'class-sections' => 'classSection',
    ]);


// ==========================================
// Chart of Accounts CRUD API
// ==========================================

Route::apiResource('chartofaccounts', ChartofaccountController::class);


// ==========================================
// Income Sources CRUD API
// ==========================================

Route::apiResource('income-sources', IncomeSourceController::class);


// ==========================================
// Subjects CRUD API
// ==========================================

Route::apiResource('subjects', SubjectController::class);


// ==========================================
// Stock CRUD API
// ==========================================

Route::apiResource('stocks', StockController::class);


// ==========================================
// Library Books CRUD API
// ==========================================

Route::apiResource('lib-books', LibBookController::class);


// ==========================================
// Students CRUD API
// ==========================================

Route::apiResource('students', StudentController::class);


// ==========================================
// Student Relatives CRUD API
// ==========================================

Route::apiResource('student-relatives', StudentRelativeController::class);


// ==========================================
// Student Transfers CRUD API
// ==========================================

Route::apiResource('student-transfers', StudentTransferController::class);


// ==========================================
// Student Documents CRUD API
// ==========================================

Route::apiResource('student-documents', StudentDocumentController::class);


// ==========================================
// Student Attendance API
// Composite Primary Key
// ==========================================

Route::get('student-attendances', [StudentAttendanceController::class, 'index']);
Route::post('student-attendances', [StudentAttendanceController::class, 'store']);

Route::get(
    'student-attendances/{studentId}/{absentDate}',
    [StudentAttendanceController::class, 'show']
);

Route::patch(
    'student-attendances/{studentId}/{absentDate}',
    [StudentAttendanceController::class, 'update']
);

Route::delete(
    'student-attendances/{studentId}/{absentDate}',
    [StudentAttendanceController::class, 'destroy']
);


// ==========================================
// Teachers CRUD API
// ==========================================

Route::apiResource('teachers', TeacherController::class);


// ==========================================
// Teacher Documents CRUD API
// ==========================================

Route::apiResource('teacher-documents', TeacherDocumentController::class);


// ==========================================
// Teacher Attendance API
// Composite Primary Key
// ==========================================

Route::get('teacher-attendances', [TeacherAttendanceController::class, 'index']);
Route::post('teacher-attendances', [TeacherAttendanceController::class, 'store']);

Route::get(
    'teacher-attendances/{teacherId}/{year}/{month}/{day}',
    [TeacherAttendanceController::class, 'show']
);

Route::patch(
    'teacher-attendances/{teacherId}/{year}/{month}/{day}',
    [TeacherAttendanceController::class, 'update']
);

Route::delete(
    'teacher-attendances/{teacherId}/{year}/{month}/{day}',
    [TeacherAttendanceController::class, 'destroy']
);


// ==========================================
// Teacher Salary API
// Composite Primary Key
// ==========================================

Route::get('teacher-salaries', [TeacherSalaryController::class, 'index']);
Route::post('teacher-salaries', [TeacherSalaryController::class, 'store']);

Route::get(
    'teacher-salaries/{teacherId}/{year}/{month}',
    [TeacherSalaryController::class, 'show']
);

Route::patch(
    'teacher-salaries/{teacherId}/{year}/{month}',
    [TeacherSalaryController::class, 'update']
);

Route::delete(
    'teacher-salaries/{teacherId}/{year}/{month}',
    [TeacherSalaryController::class, 'destroy']
);


// ==========================================
// Staff CRUD API
// ==========================================

Route::apiResource('staff', StaffController::class);


// ==========================================
// Staff Documents CRUD API
// ==========================================

Route::apiResource('staff-documents', StaffDocumentController::class);


// ==========================================
// Staff Attendance API
// Composite Primary Key
// ==========================================

Route::get('staff-attendances', [StaffAttendanceController::class, 'index']);
Route::post('staff-attendances', [StaffAttendanceController::class, 'store']);

Route::get(
    'staff-attendances/{staffId}/{year}/{month}/{day}',
    [StaffAttendanceController::class, 'show']
);

Route::patch(
    'staff-attendances/{staffId}/{year}/{month}/{day}',
    [StaffAttendanceController::class, 'update']
);

Route::delete(
    'staff-attendances/{staffId}/{year}/{month}/{day}',
    [StaffAttendanceController::class, 'destroy']
);


// ==========================================
// Staff Salary API
// Composite Primary Key
// ==========================================

Route::get('staff-salaries', [StaffSalaryController::class, 'index']);
Route::post('staff-salaries', [StaffSalaryController::class, 'store']);

Route::get(
    'staff-salaries/{staffId}/{year}/{month}',
    [StaffSalaryController::class, 'show']
);

Route::patch(
    'staff-salaries/{staffId}/{year}/{month}',
    [StaffSalaryController::class, 'update']
);

Route::delete(
    'staff-salaries/{staffId}/{year}/{month}',
    [StaffSalaryController::class, 'destroy']
);


// ==========================================
// Library Members CRUD API
// ==========================================

Route::apiResource('lib-members', LibMemberController::class);


// ==========================================
// Library Loans CRUD API
// ==========================================

Route::apiResource('lib-loans', LibLoanController::class);


// ==========================================
// Timetable API
// Composite Primary Key
// ==========================================

Route::get('timetables', [TimetableController::class, 'index']);
Route::post('timetables', [TimetableController::class, 'store']);

Route::get(
    'timetables/{weekday}/{lessonHour}/{teacherId}',
    [TimetableController::class, 'show']
);

Route::patch(
    'timetables/{weekday}/{lessonHour}/{teacherId}',
    [TimetableController::class, 'update']
);

Route::delete(
    'timetables/{weekday}/{lessonHour}/{teacherId}',
    [TimetableController::class, 'destroy']
);


// ==========================================
// Scores API
// Composite Primary Key
// ==========================================

Route::get('scores', [ScoreController::class, 'index']);
Route::post('scores', [ScoreController::class, 'store']);

Route::get(
    'scores/{studentId}/{subjectId}/{examYear}',
    [ScoreController::class, 'show']
);

Route::patch(
    'scores/{studentId}/{subjectId}/{examYear}',
    [ScoreController::class, 'update']
);

Route::delete(
    'scores/{studentId}/{subjectId}/{examYear}',
    [ScoreController::class, 'destroy']
);


// ==========================================
// Tuition Discounts API
// Composite Primary Key
// ==========================================

Route::get('tuition-discounts', [TuitionDiscountController::class, 'index']);
Route::post('tuition-discounts', [TuitionDiscountController::class, 'store']);

Route::get(
    'tuition-discounts/{studentId}/{discountYear}',
    [TuitionDiscountController::class, 'show']
);

Route::patch(
    'tuition-discounts/{studentId}/{discountYear}',
    [TuitionDiscountController::class, 'update']
);

Route::delete(
    'tuition-discounts/{studentId}/{discountYear}',
    [TuitionDiscountController::class, 'destroy']
);


// ==========================================
// Income CRUD API
// ==========================================

Route::apiResource('incomes', IncomeController::class);


// ==========================================
// Other Income API
// Composite Primary Key
// income_id + source_id
// ==========================================

Route::get('other-incomes', [OtherIncomeController::class, 'index']);
Route::post('other-incomes', [OtherIncomeController::class, 'store']);

Route::get(
    'other-incomes/{incomeId}/{sourceId}',
    [OtherIncomeController::class, 'show']
);

Route::patch(
    'other-incomes/{incomeId}/{sourceId}',
    [OtherIncomeController::class, 'update']
);

Route::delete(
    'other-incomes/{incomeId}/{sourceId}',
    [OtherIncomeController::class, 'destroy']

    
);
// Expense CRUD API
Route::apiResource('expenses', ExpenseController::class);
// Purchase CRUD API
Route::apiResource('purchases', PurchaseController::class);
// ==========================================
// Stock In and Stock Out API
// ==========================================

Route::middleware(['auth:sanctum', 'level:stock_level,1'])->group(function () {
    Route::apiResource('stock-ins', StockInController::class);
    Route::apiResource('stock-outs', StockOutController::class);
});

// ==========================================
// Authentication API
// ==========================================

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'me']);
});

// ==========================================
// Users and User Levels API
// Admin level required
// ==========================================

Route::middleware(['auth:sanctum', 'level:admin_level,1'])->group(function () {
    Route::apiResource('users', UserController::class);
    Route::apiResource('user-levels', UserLevelController::class);
});
});
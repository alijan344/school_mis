<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLevel
{
    public function handle(
        Request $request,
        Closure $next,
        string $level,
        int $minimum = 1
    ): Response {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $userLevel = $user->userLevel;

        if (!$userLevel || !in_array($level, [
            'admin_level',
            'academic_level',
            'student_level',
            'teacher_level',
            'staff_level',
            'finance_level',
            'library_level',
            'stock_level',
            'IT_level',
        ], true) || (int) $userLevel->{$level} < $minimum) {
            return response()->json([
                'message' => 'You do not have permission to perform this action.',
            ], 403);
        }

        return $next($request);
    }
}
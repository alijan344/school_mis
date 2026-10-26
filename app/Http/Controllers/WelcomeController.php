<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    public function hello()
    {
        return response()->json([
            'message' => 'Hello from our API',
            'team' => 'School MIS',
        ]);
    }

    public function greet($name)
    {
        return response()->json([
            'greeting' => "Hello, {$name}!",
        ]);
    }
}
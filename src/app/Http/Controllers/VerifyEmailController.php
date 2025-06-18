<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
    public function show()
    {
        return view('auth.verify-email'); // resources/views/auth/verify-email.blade.php
    }
}

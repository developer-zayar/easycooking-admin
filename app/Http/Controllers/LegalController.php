<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function privacyPolicy()
    {
        return view('legal.privacy');
    }

    public function termsAndConditions()
    {
        return view('legal.terms');
    }
}

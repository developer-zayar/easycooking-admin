<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function privacyPolicy()
    {
        return view('pages.privacy-policy');
    }

    public function termsConditions()
    {
        return view('pages.terms-conditions');
    }

    public function disclaimer()
    {
        return view('pages.disclaimer');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Mail;

class AuthController extends Controller
{
    public function showForm()
    {
        return view('account.delete');
    }

    public function submitForm(Request $request)
    {
        $request->validate(['reason' => 'nullable|string|max:1000', 'confirm' => 'accepted']);
        $user = Auth::user();
        // Option 1: Email admin for manual deletion
        Mail::to('admin@example.com')->send(new AccountDeletionRequested($user, $request->reason));
        // Option 2: Or delete user immediately
        // Auth::logout();
        // $user->delete();
        return redirect()->route('dashboard')->with('status', 'Your request to delete your account has been received.');
    }
}

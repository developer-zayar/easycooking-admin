<?php

namespace App\Http\Controllers;

use App\Models\AccountDeletionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function deleteAccount()
    {
        $user = auth()->user();

        $existingRequest = AccountDeletionRequest::where('user_id', $user->id)
            ->whereNotNull('requested_at')
            ->first();

        if ($existingRequest) {
            return view('account.delete-request-sent', [
                'deletionReason' => $existingRequest->reason,
            ]);
        }

        return view('account.delete');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $request = AccountDeletionRequest::create([
            'user_id' => $user->id,
            'reason' => $request->input('reason'),
            'requested_at' => now(),
        ]);

        return redirect()->route('request-sent', [
            'deletionReason' => $request->reason,
        ]); //->with('reason', $request->reasotatan);
    }

    public function submitDeleteAccountForm(Request $request)
    {
        $user = Auth::user();

        AccountDeletionRequest::create([
            'user_id' => $user->id,
            'reason' => $request->input('reason'),
            'requested_at' => now(),
        ]);

        return redirect()->route('delete-request-sent')->with('status', 'Your request to delete your account has been received.');

        // $request->validate(['reason' => 'nullable|string|max:1000', 'confirm' => 'accepted']);
        // Option 1: Email admin for manual deletion
        // Mail::to('admin@example.com')->send(new AccountDeletionRequest($user, $request->reason));
        // Option 2: Or delete user immediately
        // Auth::logout();
        // $user->delete();
        // return redirect()->route('dashboard')->with('status', 'Your request to delete your account has been received.');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\helpers\Helpers;
use App\Http\Response\ApiResponse;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Validator;
use Mail;
use Storage;
use URL;

class AuthController extends Controller
{
    public function registerDevice(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string',
            'device_name' => 'required|string',
            'fcm_token' => 'string',
        ]);

        $user = User::where('device_id', $request->device_id)->first();

        if ($user) {
            $user->update([
                'device_name' => $request->device_name,
            ]);
            if ($request->filled('fcm_token')) {
                $user->update([
                    'fcm_token' => $request->fcm_token,
                ]);
            }
            $message = 'Device updated successfully.';
        } else {
            $guestUsername = 'user_' . substr(md5(uniqid()), 0, 8);
            $user = User::create([
                'name' => $guestUsername,
                'device_id' => $request->device_id,
                'device_name' => $request->device_name,
                'fcm_token' => $request->fcm_token,
            ]);

            $message = 'Device registered successfully.';
        }

        $data['user'] = $user;
        $response = new ApiResponse(true, $message, $data);
        return response()->json($response);
    }

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'device_id' => 'string',
            'device_name' => 'string',
        ]);

        // $loginType = filter_var($request->emailOrPhone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // error_log("$loginType => $request->emailOrPhone");
        // if ($loginType == 'email') {
        //     $request->validate(['emailOrPhone' => 'unique:users,email']);
        // } else {
        //     $request->validate(['emailOrPhone' => 'unique:users,phone']);
        // }

        $user = User::where('device_id', $request->device_id)->first();
        if ($user && is_null($user->email)) {
            // Update existing device details
            $user->update([
                'name' => $request->name,
                // $loginType => $request->emailOrPhone,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'device_name' => $request->device_name,
            ]);
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'device_id' => $request->device_id,
                'device_name' => $request->device_name,
            ]);
        }

        $data['access_token'] = $user->createToken('auth_token')->plainTextToken;
        $data['token_type'] = 'Bearer';
        $data['user'] = $user;

        $response = new ApiResponse(true, 'User is created successfully.', $data);
        return response()->json($response);
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'device_id' => 'string',
            'device_name' => 'string',
            'fcm_token' => 'string',
        ]);

        // $loginType = filter_var($request->emailOrPhone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // Attempt to log in using the correct login type (email or phone)
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            $response = new ApiResponse(false, 'Email or password is incorrect. Please try again.');
            return response()->json($response);
        }

        $user = auth()->user();

        // Update device_id and device_name if provided
        if ($request->filled('device_id') || $request->filled('device_name') || $request->filled('fcm_token')) {
            $user->update([
                'device_id' => $request->device_id ?? $user->device_id,
                'device_name' => $request->device_name ?? $user->device_name,
                'fcm_token' => $request->fcm_token,
            ]);
        }

        $data['access_token'] = auth()->user()->createToken('auth_token')->plainTextToken;
        $data['token_type'] = 'Bearer';
        $data['user'] = auth()->user();

        $response = new ApiResponse(true, 'User is logged in successfully.', $data);
        return response()->json($response);
    }

    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $checkUser = User::where('email', $request->email)->first();
        if (!$checkUser) {
            $response = new ApiResponse(false, 'User is not registered!');
            return response()->json($response);
        } else {
            $otp = rand(100000, 999999);
            $updatedUser = User::where('email', $request->email)
                ->update([
                    'phone' => $otp,
                ]);

            Mail::send('emails.loginwithotp', ['otp' => $otp], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Login with OTP - EasyCooking');
            });
        }

        $response = new ApiResponse(true, 'OTP sent successfully.');
        return response()->json($response);

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        $response = new ApiResponse(true, 'User is logged out successfully.');

        return response()->json($response, 200);
    }

    public function updateProfile(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,svg,gif|max:2048',
        ]);

        $user = auth()->user();
        $imagePath = $user->image;

        // $imageUrl = $this->saveImage($request->image, 'profiles');

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            // Generate clean image name from email
            $emailSlug = Str::slug(pathinfo($user->email, PATHINFO_FILENAME));
            // $extension = $image->getClientOriginalExtension();
            // $fileName = $emailSlug . '.' . $extension;
            $fileName = $emailSlug . '.png';

            // Resize the image using Intervention
            $resizedImage = Image::make($image->path())
                ->fit(100, 100, function ($const) {
                    $const->aspectRatio();
                })->encode('png');

            // Optionally delete old file (only if you store old image name)
            if ($user->image && Storage::disk('profiles')->exists(basename($fileName))) {
                Storage::disk('profiles')->delete(basename($fileName));
            }

            // Save to storage disk 'profiles'
            Storage::disk('profiles')->put($fileName, $resizedImage);

            // Update image path in database
            $user->image = URL::to('/') . '/storage/profiles/' . $fileName; //Storage::disk('profiles')->url($fileName);

            // $relativePath = "profiles/$fileName";
            // $fullPath = public_path($relativePath);

            // // Ensure the profiles directory exists
            // $directory = public_path('profiles');
            // if (!File::exists($directory)) {
            //     File::makeDirectory($directory, 0755, true);
            // }

            // // Delete old image if it exists
            // if (File::exists($fullPath)) {
            //     File::delete($fullPath);
            // }

            // // Resize and save image to profiles/
            // $img = Image::make($image->path());
            // $img->fit(100, 100, function ($const) {
            //     $const->aspectRatio();
            // })->save($fullPath);

            // $imagePath = $relativePath; // e.g., profiles/john-doe.jpg

            // $user->update([
            //     'image' => $imagePath,
            // ]);
        }

        // Update name
        $user->name = $attr['name'];
        $user->save();

        $data['user'] = $user;

        $response = new ApiResponse(true, 'User updated successfully.', $data);
        return response()->json($response, 200);

    }

    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'provider' => 'required|string',
            'provider_id' => 'required',
            'image' => 'string',
            'device_id' => 'string',
            'device_name' => 'string',
            'fcm_token' => 'string',
        ]);

        if ($validator->fails()) {
            $response = new ApiResponse(false, 'validation_error', $validator->errors()->all());
            return response()->json($response);
        }

        $user = User::where('provider_id', $request->provider_id)->first();

        if (!$user) {
            if ($request->email) {
                $emailExists = User::where('email', $request->email)->first();
                if ($emailExists) {
                    $response = new ApiResponse(false, 'Account already exists');
                    return response()->json($response);
                }
            }

            // if ($request->mobile) {
            //     $mobileExists = User::where('mobile', $request->mobile)->first();
            //     if ($mobileExists) {
            //         $response = new ApiResponse(false, 'Mobile already exists');
            //         return response()->json($response);
            //     }
            // }

            $password = Helpers::generatePassword(8);

            $user = User::where('device_id', $request->device_id)->first();
            if ($user && is_null($user->email)) {
                // Update existing device details
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $password,
                    'provider' => $request->provider,
                    'provider_id' => $request->provider_id,
                    'image' => $request->image,
                    'device_name' => $request->device_name,
                    'fcm_token' => $request->fcm_token,
                ]);
            } else {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => $password,
                    'provider' => $request->provider,
                    'provider_id' => $request->provider_id,
                    'image' => $request->image,
                    'device_id' => $request->device_id,
                    'device_name' => $request->device_name,
                    'fcm_token' => $request->fcm_token,
                ]);
            }
        } else {
            $user->update([
                'device_id' => $request->device_id,
                'device_name' => $request->device_name,
                'fcm_token' => $request->fcm_token,
            ]);
        }

        // $authUser = User::where('provider_id', $request->provider_id)
        //     ->where('provider', $request->provider)
        //     ->first();

        // if (!$authUser) {
        //     $response = new ApiResponse(false, 'Account is not valid');
        //     return response()->json($response);
        // }

        // $loginUser = User::find($authUser->id);
        $data['access_token'] = $user->createToken('auth_token')->plainTextToken;
        $data['token_type'] = 'Bearer';
        $data['user'] = $user;

        $response = new ApiResponse(true, 'User is logged in successfully.', $data);
        return response()->json($response);
    }

    /**
     * Send OTP for password reset
     */
    public function sendResetOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            $response = new ApiResponse(false, $validator->errors()->first());
            return response()->json($response);
        }

        $user = User::where('email', $request->email)->first();
        $otp = rand(100000, 999999); // Generate OTP

        // Store OTP in the database
        $user->otp = $otp;
        $user->otp_expires_at = now()->addMinutes(10); // OTP expires in 10 minutes
        $user->save();

        // Send OTP via email
        Mail::send('emails.reset-password', ['otp' => $otp], function ($message) use ($user) {
            $message->to($user->email)->subject('Password Reset OTP');
        });

        $response = new ApiResponse(true, 'OTP sent to your email.');
        return response()->json($response);
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
        ]);

        if ($validator->fails()) {
            $response = new ApiResponse(false, $validator->errors()->first());
            return response()->json($response);
        }

        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

        if (!$user || now()->greaterThan($user->otp_expires_at)) {
            $response = new ApiResponse(false, 'Invalid or expired OTP.');
            return response()->json($response);
        }

        $response = new ApiResponse(true, 'OTP verified successfully.');
        return response()->json($response);
    }

    /**
     * Reset Password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:6',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            $response = new ApiResponse(false, $validator->errors()->first());
            return response()->json($response);
        }

        $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

        if (!$user || now()->greaterThan($user->otp_expires_at)) {
            $response = new ApiResponse(false, 'Invalid or expired OTP.');
            return response()->json($response);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->otp = null; // Clear OTP after reset
        $user->otp_expires_at = null;
        $user->save();

        $response = new ApiResponse(true, 'Password reset successfully.');
        return response()->json($response);
    }

}

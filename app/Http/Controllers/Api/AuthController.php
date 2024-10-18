<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\helpers\Helpers;
use App\Http\Response\ApiResponse;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        //create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $data['access_token'] = $user->createToken($request->email)->plainTextToken;
        $data['token_type'] = 'Bearer';
        $data['user'] = $user;

        $response = new ApiResponse(true, 'User is created successfully.', $data);
        return response()->json($response);
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'emailOrPhone' => 'required',
            'password' => 'required|min:6',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // Attempt to log in using the correct login type (email or phone)
        $credentials = [
            $loginType => $request->emailOrPhone,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            $response = new ApiResponse(false, 'Invalid credentials');
            return response()->json($response);
        }

        $data['access_token'] = auth()->user()->createToken('auth_token')->plainTextToken;
        $data['token_type'] = 'Bearer';
        $data['user'] = auth()->user();

        $response = new ApiResponse(true, 'User is logged in successfully.', $data);
        return response()->json($response);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        $response = new ApiResponse(true, 'User is logged out successfully.');

        return response()->json($response, 200);
    }

    public function updateUser(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string',
        ]);

        $imageUrl = $this->saveImage($request->image, 'profiles');

        auth()->user()->update([
            'name' => $attr['name'],
            'image' => $imageUrl,
        ]);

        $response = new ApiResponse(true, 'User updated successfully.', auth()->user());
        return response()->json($response, 200);

    }

    public function socialLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'provider' => 'required|string',
            'provider_id' => 'required',
        ]);

        if ($validator->fails()) {
            $response = new ApiResponse(false, 'validation_error', $validator->errors()->all());
            return response()->json($response);
        }

        $userData = User::where('provider_id', $request->provider_id)->first();

        if (!$userData) {
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

            $newUser = new User();
            $newUser->name = $request->name;
            $newUser->email = $request->email;
            $newUser->password = $password;
            $newUser->provider = $request->provider;
            $newUser->provider_id = $request->provider_id;

            $newUser->save();

        }

        $authUser = User::where('provider_id', $request->provider_id)
            ->where('provider', $request->provider)
            ->first();

        if (!$authUser) {
            $response = new ApiResponse(false, 'Account is not valid');
            return response()->json($response);
        }

        $data['access_token'] = $authUser->createToken('auth_token')->plainTextToken;
        $data['token_type'] = 'Bearer';
        $loginUser = User::find($authUser->id);
        $data['user'] = $loginUser;

        $response = new ApiResponse(true, 'User is logged in successfully.', $data);
        return response()->json($response);
    }


}

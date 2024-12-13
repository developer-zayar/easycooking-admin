<?php

namespace App\Http\Controllers;

use App\Http\Response\ApiResponse;
use App\Models\User;
use Google\Client as GoogleClient;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class FCMController extends Controller
{
    //update fcm token
    public function updateDeviceToken(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'fcm_token' => 'required|string',
        ]);

        // $request->user()->update(['fcm_token' => $request->fcm_token]);
        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update(['fcm_token' => $request->fcm_token]);

        return response()->json(['message' => 'Device token updated successfully']);
    }

    public function sendFcmNotification(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
            'body' => 'required|string',
            'image_url' => 'string',
        ]);

        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $fcm = $user->fcm_token;

        if (!$fcm) {
            $response = new ApiResponse(false, 'User does not have a device token');
            return response()->json($response, 400);
            // return response()->json(['message' => 'User does not have a device token'], 400);
        }

        $title = $request->title;
        $description = $request->body;
        $projectId = config('services.fcm.easycookingv2');

        //easycookingv2-firebase-adminsdk-rfq97-d3df5c3b02.json
        $credentialsFilePath = storage_path('app/json/easycookingv2-firebase-adminsdk-rfq97-d3df5c3b02.json');
        $client = new GoogleClient();
        $client->setAuthConfig($credentialsFilePath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        $token = $client->getAccessToken();

        $access_token = $token['access_token'];
        $headers = [
            "Authorization: Bearer $access_token",
            'Content-Type: application/json'
        ];

        $data = [
            "message" => [
                "token" => $fcm,
                "notification" => [
                    "title" => $title,
                    "body" => $description,
                ],
                "data" => [
                    "title" => "Hello",
                    "body" => "This is from data.",
                ]
            ]
        ];
        $payload = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/v1/projects/easycookingv2/messages:send");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_VERBOSE, true); // Enable verbose output for debugging
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            $response = new ApiResponse(false, 'CURL Error: ' . $err);
            return response()->json($response, 500);
            // return response()->json([
            //     'message' => 'Curl Error: ' . $err
            // ], 500);
        } else {
            $response = new ApiResponse(false, 'Notification has been sent', json_decode($response, true));
            return response()->json($response);
            // return response()->json([
            //     'message' => 'Notification has been sent',
            //     'response' => json_decode($response, true)
            // ]);
        }

    }
}

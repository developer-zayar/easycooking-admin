<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use App\Models\AppSetting;
use App\Models\NoEat;
use Illuminate\Http\Request;

class AppSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = AppSetting::all();

        $response = new ApiResponse(true, 'AppSettings', $data);
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attr = $request->validate([
            'key' => 'required|unique:app_settings|max:255',
            'value' => 'required|string',
            'remark' => 'string',
        ]);

        $data = AppSetting::create($request->all());

        $response = new ApiResponse(true, 'AppSetting created.', $data);
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = AppSetting::find($id);

        if (!$data) {
            $response = new ApiResponse(false, 'AppSetting Not found.');
            return response()->json($response);
        }

        $response = new ApiResponse(true, 'AppSetting details', $data);
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = AppSetting::find($id);

        if (!$data) {
            $response = new ApiResponse(false, 'AppSetting Not found.');
            return response()->json($response);
        }

        $data->update($request->all());

        $response = new ApiResponse(true, 'AppSetting updated.', $data);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = AppSetting::find($id);

        if (!$data) {
            $response = new ApiResponse(false, 'AppSetting Not found.');
            return response()->json($response);
        }

        $data->delete();

        $response = new ApiResponse(true, 'AppSetting deleted.');
        return response()->json($response);
    }
}

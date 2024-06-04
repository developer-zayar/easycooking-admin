<?php

namespace App\Http\Controllers;

use App\Http\Response\ApiResponse;
use Illuminate\Http\Request;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class GoogleFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $file = $request->file('file');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $uploadfile = Gdrive::put('images/' . $fileName, $file);

        $data = Gdrive::get('images/' . $fileName);

        // $response = new ApiResponse(true, 'Image Uploaded!', $data->);
        // return response()->json($response);
        // return response($data->file, 200)
        //     ->header('Content-Type', $data->id);
        dd($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

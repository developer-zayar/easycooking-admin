<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use App\Models\NoEat;
use Illuminate\Http\Request;

class NoEatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $noeat = NoEat::all();

        $response = new ApiResponse(true, 'NoEat Together', $noeat, $noeat->count());
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attr = $request->validate([
            'item1' => 'required|string',
            'item2' => 'required|string',
            'action' => 'required|string',
        ]);

        $noeat = NoEat::create($request->all());



        $response = new ApiResponse(true, 'NoEat created.', $noeat);
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $noeat = NoEat::find($id);

        if (!$noeat) {
            $response = new ApiResponse(false, 'NoEat not found.');
            return response()->json($response);
        }

        $response = new ApiResponse(true, 'NoEat details', $noeat);
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $noeat = NoEat::find($id);

        if (!$noeat) {
            $response = new ApiResponse(false, 'NoEat not found.');
            return response()->json($response);
        }

        $noeat->update($request->all());

        $response = new ApiResponse(true, 'NoEat updated.', $noeat);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $noeat = NoEat::find($id);

        if (!$noeat) {
            $response = new ApiResponse(false, 'NoEat not found.');
            return response()->json($response);
        }

        $noeat->delete();

        $response = new ApiResponse(true, 'NoEat deleted.');
        return response()->json($response);
    }
}

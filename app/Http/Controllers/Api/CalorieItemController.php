<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use Illuminate\Http\Request;
use App\Models\CalorieItem;

class CalorieItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $calorieItems = CalorieItem::all();
        $response = new ApiResponse(true, 'Calorie Items', $calorieItems);
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|unique:calorie_items,id',
            'name' => 'string',
            'category' => 'nullable|string',
            'category_key' => 'nullable|string',
            'weight' => 'string',
            'calories' => 'integer',
        ]);

        $item = CalorieItem::create($data);
        $response = new ApiResponse(true, "Calorie Item created", $item);
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = CalorieItem::find($id);

        if (!$item) {
            $response = new ApiResponse(false, 'Calorie Item not found.');
            return response()->json($response);
        }

        $response = new ApiResponse(true, 'Calorie Item details', $item);
        return response()->json($response);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = CalorieItem::findOrFail($id);

        $data = $request->validate([
            'name' => 'string',
            'category' => 'nullable|string',
            'category_key' => 'nullable|string',
            'weight' => 'string',
            'calories' => 'integer',
        ]);

        $item->update($data);
        $response = new ApiResponse(true, 'Calorie Item updated', $item);
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = CalorieItem::find($id);

        if (!$item) {
            $response = new ApiResponse(false, 'Calorie Item not found.');
            return response()->json($response);
        }

        $item->delete();

        $response = new ApiResponse(true, 'Calorie Item deleted.', $item);
        return response()->json($response);
    }
}

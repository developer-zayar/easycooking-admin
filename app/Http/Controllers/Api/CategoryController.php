<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use App\Models\Category;
use DB;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $type = $request->query('type', 0);

        // $categories = Category::orderBy("created_at", "desc")
        //     ->where('type', $type)
        //     ->get();
        $categories = Category::orderBy("created_at", "desc")
            ->select('id', 'name', 'image')
            ->where('type', $type)
            ->get();


        $response = new ApiResponse(true, "categories", $categories);
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attr = $request->validate([
            "title" => "required|string",
        ]);

        $category = Category::create($request->all());

        $response = new ApiResponse(true, "Category created.", $category);
        return response()->json($response);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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

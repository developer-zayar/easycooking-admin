<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use App\Http\Response\ApiResponse;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recipes = Recipe::with('category')
            ->with(['images', 'reviews'])
            ->limit(20)
            ->orderBy('created_at', 'desc')
            ->get();

        $response = new ApiResponse(true, 'recipes', $recipes);
        return response()->json($response);
    }

    public function getRecipeByCategoryId($category_id)
    {
        $recipes = Recipe::with('category')
            ->select('id', 'name', 'image', 'views', 'fav', 'category_id', 'post_id')
            ->where('category_id', $category_id)
            ->get();

        // if ($recipes->isEmpty()) {
        //     return response()->json(['message' => 'No posts found for the specified category ID'], 404);
        // }

        $response = new ApiResponse(true, 'recipes by category', $recipes);
        return response()->json($response);
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
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!ctype_digit($id)) {
            $response = new ApiResponse(false, 'Invalid ID');
            return response()->json($response);
        }

        $recipe = Recipe::with('category')
            ->with(['images', 'reviews'])
            ->find($id);

        if (!$recipe) {
            $response = new ApiResponse(false, 'Item not found', $recipe);
            return response()->json($response);
        }

        $response = new ApiResponse(true, 'recipe details', $recipe);
        return response()->json($response);
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

    public function search(Request $request)
    {
        $query = $request->input('query', '');
        $perPage = $request->input('per_page', 20);
        $page = $request->input('page', 1);

        $recipes = Recipe::with('category')
            ->select('id', 'name', 'image', 'views', 'fav', 'category_id', 'post_id')
            ->where('category_id', '<>', 1000) // Exclude category 1000
            ->when($query, function ($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        $response = [
            'success' => true,
            'message' => 'Search results',
            'query' => $query,
            'page' => $recipes->currentPage(),
            'total_pages' => $recipes->lastPage(),
            'total_results' => $recipes->total(),
            'results' => $recipes->items(),
        ];

        return response()->json($response);
    }

    public function newRecipe(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $page = $request->input('page', 1);

        $recipes = Recipe::with('category')
            ->select('id', 'name', 'image', 'views', 'fav', 'category_id', 'post_id')
            ->where('category_id', '<>', 1000)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
        // ->take(20)
        // ->get();

        $response = [
            'success' => true,
            'message' => 'New recipes',
            'page' => $recipes->currentPage(),
            'total_pages' => $recipes->lastPage(),
            'total_results' => $recipes->total(),
            'results' => $recipes->items(),
        ];

        return response()->json($response);
    }

    public function popular(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $page = $request->input('page', 1);

        $recipes = Recipe::with('category')
            ->select('id', 'name', 'image', 'views', 'fav', 'category_id', 'post_id')
            ->where('category_id', '<>', 1000)
            ->orderBy('views', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
        // ->take(20)
        // ->get();

        $response = [
            'success' => true,
            'message' => 'Popular recipes',
            'page' => $recipes->currentPage(),
            'total_pages' => $recipes->lastPage(),
            'total_results' => $recipes->total(),
            'results' => $recipes->items(),
        ];

        return response()->json($response);
    }

    public function cookingKnowledge(Request $request)
    {
        $perPage = $request->input('per_page', 20);
        $page = $request->input('page', 1);

        $recipes = Recipe::with('category')
            ->select('id', 'name', 'image', 'views', 'fav', 'category_id', 'post_id')
            // ->whereHas('category', function ($query) {
            //     $query->where('id', 1000);
            // })
            ->where('category_id', '=', 1000)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);
        // ->take(10)
        // ->get();

        $response = [
            'success' => true,
            'message' => 'Cooking knowledge',
            'page' => $recipes->currentPage(),
            'total_pages' => $recipes->lastPage(),
            'total_results' => $recipes->total(),
            'results' => $recipes->items(),
        ];

        return response()->json($response);
    }

}

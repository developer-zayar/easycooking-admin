<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use App\Http\Response\ApiResponse;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    // Toggle favorite status for posts or recipes
    public function toggleFavorite($type, $id)
    {
        $user = Auth::user();

        $modelClass = $type === 'post' ? Post::class : ($type === 'recipe' ? Recipe::class : null);

        if (!$modelClass || !$modelClass::find($id)) {
            return response()->json(['error' => 'Invalid type or ID'], 400);
        }

        $favorite = Favorite::where('user_id', $user->id)
            ->where('favoritable_id', $id)
            ->where('favoritable_type', $modelClass)
            ->first();

        if ($favorite) {
            // Remove from favorites
            $favorite->delete();
            $response = new ApiResponse(true, ucfirst($type) . ' removed from favorites', $favorite);
            return response()->json($response);
        } else {
            // Add to favorites
            $favorite = Favorite::create([
                'user_id' => $user->id,
                'favoritable_id' => $id,
                'favoritable_type' => $modelClass,
            ]);

            $response = new ApiResponse(true, ucfirst($type) . ' added to favorites', $favorite);
            return response()->json($response);
        }
    }

    public function addFavorite(Request $request, $type)
    {
        $user = Auth::user();

        // Validate input (single or array of IDs)
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:' . ($type === 'post' ? 'posts' : 'recipes') . ',id'
        ]);

        $modelClass = $this->getModelClass($type);
        if (!$modelClass) {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        $favorites = [];
        foreach ($request->ids as $id) {
            $favorite = Favorite::firstOrCreate([
                'user_id' => $user->id,
                'favoritable_id' => $id,
                'favoritable_type' => $modelClass,
            ]);
            $favorites[] = $favorite;
        }

        $response = new ApiResponse(true, ucfirst($type) . ' added to favorites', $favorites);
        return response()->json($response);
    }

    public function removeFavorite(Request $request, $type)
    {
        $user = Auth::user();

        // Validate input (single or array of IDs)
        $request->validate([
            'ids' => 'required|array|min:1',
            'ids.*' => 'integer|exists:' . ($type === 'post' ? 'posts' : 'recipes') . ',id'
        ]);

        $modelClass = $this->getModelClass($type);
        if (!$modelClass) {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        Favorite::where('user_id', $user->id)
            ->whereIn('favoritable_id', $request->ids)
            ->where('favoritable_type', $modelClass)
            ->delete();

        $response = new ApiResponse(true, ucfirst($type) . ' removed from favorites', $request->ids);
        return response()->json($response);
    }

    // Helper function to get the model class
    private function getModelClass($type)
    {
        return $type === 'post' ? Post::class : ($type === 'recipe' ? Recipe::class : null);
    }

    // Get all favorite posts
    public function getFavoritePosts()
    {
        $user = Auth::user();

        $favorites = Favorite::where('user_id', $user->id)
            ->where('favoritable_type', Post::class)
            ->orderBy('created_at', 'desc')
            ->with([
                'favoritable' => function ($query) {
                    $query->with(['images'])->withCount(['reviews', 'likes']);
                }
            ])
            ->get()
            ->pluck('favoritable');

        $response = new ApiResponse(true, 'favorite posts', $favorites);
        return response()->json($response);
    }

    // Get all favorite recipes
    public function getFavoriteRecipes()
    {
        $user = Auth::user();

        $favorites = Favorite::where('user_id', $user->id)
            ->where('favoritable_type', Recipe::class)
            ->orderBy('created_at', 'desc')
            ->with([
                'favoritable' => function ($query) {
                    $query->with('category')->with(['images', 'reviews']);
                }
            ])
            ->get()
            ->pluck('favoritable');

        $response = new ApiResponse(true, 'favorite recipes', $favorites);
        return response()->json($response);
    }
}

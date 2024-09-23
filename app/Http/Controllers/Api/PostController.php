<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use App\Models\Post;
use App\Models\PostLike;
use DB;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user() == null) {
            $posts = Post::with(['images'])
                ->withCount('reviews', 'likes')
                ->selectRaw('CAST((SELECT AVG(post_reviews.rating) FROM post_reviews WHERE post_reviews.post_id = posts.id) AS DECIMAL(10, 2)) as average_rating')
                // ->selectRaw('(SELECT AVG(post_reviews.rating) FROM post_reviews WHERE post_reviews.post_id = posts.id) as average_rating')
                ->limit(20)
                ->orderBy('created_at', 'desc')
                ->simplePaginate(20);
        } else {
            $posts = Post::with(['images'])
                ->withCount('reviews', 'likes')
                ->selectRaw('CAST((SELECT AVG(post_reviews.rating) FROM post_reviews WHERE post_reviews.post_id = posts.id) AS DECIMAL(10, 2)) as average_rating')
                ->with('likes', function ($like) {
                    return $like->where('user_id', auth()->user()->id)
                        ->select('id', 'user_id', 'post_id')->get();
                })
                ->limit(20)
                ->orderBy('created_at', 'desc')
                ->simplePaginate(20);
        }


        // $response = new ApiResponse(true, 'Posts', $posts);
        return response()->json($posts);
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
    public function show(string $id)
    {
        if (!ctype_digit($id)) {
            $response = new ApiResponse(false, 'Invalid ID');
            return response()->json($response);
        }

        $post = Post::find($id)
            ->with(['images'])
            ->withCount('reviews', 'likes')
            ->selectRaw('CAST((SELECT AVG(post_reviews.rating) FROM post_reviews WHERE post_reviews.post_id = posts.id) AS DECIMAL(10, 2)) as average_rating')
            ->find($id);

        if (!$post) {
            $response = new ApiResponse(false, 'Item not found', $post);
            return response()->json($response);
        }

        $response = new ApiResponse(true, 'post details', $post);
        return response()->json($response);
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

    public function likeOrUnlike($id)
    {
        $post = Post::find($id);

        if (!$post) {
            $response = new ApiResponse(false, 'Post not found.');
            return response()->json($response);
        }

        $like = $post->likes()->where('user_id', auth()->user()->id)->first();

        if (!$like) {
            PostLike::create([
                'user_id' => auth()->user()->id,
                'post_id' => $id,
            ]);

            $response = new ApiResponse(true, 'Liked:' . $post->id);
            return response()->json($response);
        }

        $like->delete();

        $response = new ApiResponse(true, 'Unliked');
        return response()->json($response);

    }

    public function saveOrUnsave($id)
    {
        $post = Post::find($id);

        if (!$post) {
            $response = new ApiResponse(false, 'Post not found.');
            return response()->json($response);
        }

        $like = $post->likes()
            ->where('user_id', auth()->user()->id)
            ->where('is_save', 1)
            ->first();

        if (!$like) {
            PostLike::create([
                'user_id' => auth()->user()->id,
                'post_id' => $id,
                'is_save' => 1,
            ]);

            $response = new ApiResponse(true, 'Saved:' . $post->id);
            return response()->json($response);
        }

        $like->is_save = 0; // Toggle the is_save attribute
        $like->save();

        $response = new ApiResponse(true, 'UnSaved:' . $post->id);
        return response()->json($response);

    }

}

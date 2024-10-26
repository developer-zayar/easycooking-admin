<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use App\Models\Post;
use App\Models\PostReview;
use Illuminate\Http\Request;

class PostReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $post = Post::find($id);

        if (!$post) {
            $response = new ApiResponse(false, 'Post not found.');
            return response()->json($response);
        }

        $postReviews = $post->reviews()
            ->with('user:id,name,image')
            ->get();

        $response = new ApiResponse(true, 'post reviews', $postReviews);
        return response()->json($response);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $post = Post::find($id);

        if (!$post) {
            $response = new ApiResponse(false, 'Post not found.');
            return response()->json($response);
        }

        $attr = $request->validate([
            'rating' => 'integer|required',
            'comment' => 'string|nullable',
        ]);

        $postReview = PostReview::create([
            'post_id' => $id,
            'user_id' => auth()->user()->id,
            'rating' => $request['rating'],
            'comment' => $request['comment'],
        ]);

        $response = new ApiResponse(true, 'Review saved.', $postReview);
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
        $review = PostReview::find($id);

        if (!$review) {
            $response = new ApiResponse(false, 'Review not found.');
            return response()->json($response);
        }

        // if ($review->user_id != auth()->user()->id) {
        //     $response = new ApiResponse(false, "Permission denied.");
        //     return response()->json($response, 403);
        // }

        $attr = $request->validate([
            'rating' => 'integer|required',
            'comment' => 'string|nullable',
        ]);

        $review->update($request->all());

        $response = new ApiResponse(true, "Review deleted.");
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $review = PostReview::find($id);

        if (!$review) {
            $response = new ApiResponse(false, 'Review not found.');
            return response()->json($response);
        }

        // if ($review->user_id != auth()->user()->id) {
        //     $response = new ApiResponse(false, "Permission denied.");
        //     return response()->json($response, 403);
        // }

        $review->delete();

        $response = new ApiResponse(true, "Review deleted.");
        return response()->json($response);
    }
}

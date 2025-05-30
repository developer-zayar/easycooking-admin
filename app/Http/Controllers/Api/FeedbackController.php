<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Response\ApiResponse;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Validator;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $feedback = Feedback::with(['user:id,name', 'post:id,title', 'recipe:id,name'])
            ->orderBy('created_at', 'desc')
            ->simplePaginate(10);

        $response = new ApiResponse(true, 'Feedback', $feedback);
        return response()->json($feedback);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'message' => 'required|string|min:5',
            'post_id' => 'nullable|exists:posts,id',
            'recipe_id' => 'nullable|exists:recipes,id',
        ]);

        if ($validator->fails()) {
            $response = new ApiResponse(false, data: $validator->errors());
            return response()->json($response);
        }

        $feedback = Feedback::create($request->all());

        $response = new ApiResponse(true, 'Feedback saved.', $feedback);
        return response()->json($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $feedback = Feedback::with(['user:id,name', 'post:id,title', 'recipe:id,name'])->find($id);

        if (!$feedback) {
            return response()->json(['success' => false, 'message' => 'Feedback not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $feedback]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['success' => false, 'message' => 'Feedback not found'], 404);
        }

        $feedback->update($request->only('message', 'status', 'post_id', 'recipe_id'));

        return response()->json(['success' => true, 'message' => 'Feedback updated', 'data' => $feedback]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $feedback = Feedback::find($id);

        if (!$feedback) {
            return response()->json(['success' => false, 'message' => 'Feedback not found'], 404);
        }

        $feedback->delete();
        return response()->json(['success' => true, 'message' => 'Feedback deleted']);
    }
}

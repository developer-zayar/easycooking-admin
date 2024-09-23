<?php

use App\Http\Controllers\Api\AppSettingController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NoEatController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\PostReviewController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\RecipeReviewController;
use App\Http\Controllers\GoogleFileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['apikey'])->group(function () {
    // ...
    // AppSetting
    Route::get('appsettings', [AppSettingController::class, 'index']);

    // Recipe
    Route::get('/recipes', [RecipeController::class, 'index']);
    Route::get('/recipes/new_recipe', [RecipeController::class, 'newRecipe']);
    Route::get('/recipes/popular', [RecipeController::class, 'popular']);
    Route::get('/recipes/cooking_knowledge', [RecipeController::class, 'cookingKnowledge']);
    Route::get('/recipes/{id}', [RecipeController::class, 'show']);
    Route::get('/recipes/category/{category_id}', [RecipeController::class, 'getPostByCategoryId']);

    // Recipe review
    Route::get('/recipes/{id}/reviews', [RecipeReviewController::class, 'index']);

    // Category
    Route::apiResource('categories', CategoryController::class);

    // NoEat
    Route::apiResource('noeat', NoEatController::class);

    // Post
    Route::apiResource('posts', PostController::class);

    // PostReview
    Route::get('/posts/{id}/reviews', [PostReviewController::class, 'index']);

    //Route::post('/fileupload', [GoogleFileController::class, 'store']);

    // Public routes of authtication
    Route::controller(AuthController::class)->group(function () {
        Route::post('/register', 'register');
        Route::post('/login', 'login');
        Route::post('/social-login', 'socialLogin');
        Route::post('/social-logout', 'socialLogout');
    });

    // Protected routes of product and logout
    Route::middleware('auth:sanctum')->group(function () {
        // Auth
        Route::post('/logout', [AuthController::class, 'logout']);

        // Recipe Review
        Route::post('/recipes/{id}/reviews', [RecipeReviewController::class, 'store']);
        Route::put('/recipes/reviews/{id}', [RecipeReviewController::class, 'update']);
        Route::delete('/recipes/reviews/{id}', [RecipeReviewController::class, 'destroy']);
        // Save
        Route::get('/recipes/{id}/save', [RecipeReviewController::class, 'saveOrUnsave']);

        // Post review
        Route::post('/posts/{id}/reviews', [PostReviewController::class, 'store']);
        Route::put('/posts/reviews/{id}', [PostReviewController::class, 'update']);
        Route::delete('/posts/reviews/{id}', [PostReviewController::class, 'destroy']);
        // Like
        Route::get('/posts/{id}/like', [PostController::class, 'likeOrUnlike']);
        // Save
        Route::get('/posts/{id}/save', [RecipeReviewController::class, 'saveOrUnsave']);
    });

});





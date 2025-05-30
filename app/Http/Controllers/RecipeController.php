<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function show($slug)
    {
        $recipe = Recipe::where('slug', $slug)->firstOrFail();
        return view('recipe.show', compact('recipe'));
    }
}

<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [HomeController::class, 'index']);
Route::get('/app-features', [HomeController::class, 'appFeatures'])->name('app.features');
Route::get('/app-gallery', [HomeController::class, 'appGallery'])->name('app.gallery');
Route::get('/contact', [HomeController::class, 'appGallery'])->name('contact');
Route::get('/privacy-policy', [LegalController::class, 'privacyPolicy'])->name('privacy.policy');
Route::get('/terms-and-conditions', [LegalController::class, 'termsAndConditions'])->name('terms.conditions');

Route::get('/recipe/{slug}', [RecipeController::class, 'show'])->name('recipe.show');
Route::get('/share/recipes/{slug}', [RecipeController::class, 'show'])->name('recipe.show');
Route::get('/post/{slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/share/posts/{slug}', [PostController::class, 'show'])->name('post.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/delete-account', [AuthController::class, 'deleteAccount'])->name('account.delete');
    Route::post('/delete-account', [AuthController::class, 'submitDeleteAccountForm'])->name('account.delete.submit');
    Route::get('/delete-request-sent', function () {
        return view('account.delete-request-sent');
    })->name('delete-request-sent');
});

Route::get('put', function () {
    Storage::disk('google')->put('images/test.txt', 'Hello World');
    return 'File was saved to Google Drive';
});

Route::get('get', function () {
    $files = Storage::disk('google')->allFiles();
    $urls = [];
    foreach ($files as $file) {
        $urls[] = Storage::disk('google')->url('1712750073.png');
    }

    dd($urls);
});

Route::get('get-fileinfo', function () {
    // there can be duplicate file names!
    $filename = 'images/cooking.png';

    // $rawData = Storage::disk('google')->get($filename); // raw content
    $file = Storage::disk('google')->getAdapter()->getMetadata($filename); // array with file info

    return response($file, 200)
        ->header('ContentType', $file->mimeType())
        ->header('Content-Disposition', "attachment; filename=$filename");
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
    'confirm' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

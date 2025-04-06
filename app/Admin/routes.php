<?php

use Illuminate\Routing\Router;
use App\Admin\Controllers\AppSettingController;
use App\Admin\Controllers\CategoryController;
use App\Admin\Controllers\PostController;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('app-settings', AppSettingController::class);
    $router->resource('categories', CategoryController::class);
    $router->resource('posts', PostController::class);
});

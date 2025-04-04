<?php

use OpenAdmin\Admin\Admin;
use Illuminate\Routing\Router;
use App\Admin\Controllers\AppSettingController;
use App\Admin\Controllers\CategoryController;

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
});

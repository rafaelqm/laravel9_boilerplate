<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Rap2hpoutre\LaravelLogViewer\LogViewerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

    Route::get('/welcome', function () {
        return view('welcome');
    });

$router->group(
    [
        'middleware' => 'auth',
        'prefix' => '/'
    ],
    function () use ($router) {
        $router->get(
            '/examples',
            function () {
                return view('examples');
            }
        );

        $router->get(
            '/',
            [
                HomeController::class,
                'index'
            ]
        );

        $router->get(
            '/home',
            [
                HomeController::class,
                'index'
            ]
        )->name('home');
        $router->post('arquivo_temporario', [HomeController::class, 'arquivoTemporario']);

        $router->get('/users/{id}/edit', 'UserController@edit');
        $router->patch('/users/{id}', 'UserController@update');
        $router->put('/users/{id}', 'UserController@update');

        $router->get('console/logs', [LogViewerController::class, 'index']);

        require 'web/search.routes.php';
        require 'web/users.routes.php';
        require 'web/roles.routes.php';
    }
);

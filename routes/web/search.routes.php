<?php
// roles
use App\Http\Controllers\CityController;
use App\Http\Controllers\SearchController;

$router->group(
    [
        'prefix' => 'busca',
    ],
    function () use ($router) {
        $router->get('cep', [
            SearchController::class,
            'buscaPorCep'
        ])->name('search.zipcode');
    }
);

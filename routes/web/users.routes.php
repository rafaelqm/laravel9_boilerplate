<?php

$router->get(
    '/users/{id}/edit',
    '\App\Http\Controllers\UserController@edit'
);
$router->patch(
    '/users/{id}',
    '\App\Http\Controllers\UserController@update'
);
$router->put(
    '/users/{id}',
    '\App\Http\Controllers\UserController@update'
);

// Users
$router->group(
    [
        'prefix' => 'users',
        'middleware' => 'permission:view.users',
    ]
    ,
    function () use ($router) {
        $router->get(
            '',
            ['as' => 'users.index', 'uses' => '\App\Http\Controllers\UserController@index']
        );
        $router->post(
            '',
            ['as' => 'users.store', 'uses' => '\App\Http\Controllers\UserController@store']
        )
            ->middleware(
                'permission:create.users'
            );
        $router->get(
            '/create',
            ['as' => 'users.create', 'uses' => '\App\Http\Controllers\UserController@create']
        )
            ->middleware(
                'permission:create.users'
            );
        $router->put(
            '/{user}',
            ['as' => 'users.update', 'uses' => '\App\Http\Controllers\UserController@update']
        )
            ->middleware(
                'permission:edit.users'
            );
        $router->patch(
            '/{user}',
            ['as' => 'users.update', 'uses' => '\App\Http\Controllers\UserController@update']
        )
            ->middleware(
                'permission:edit.users'
            );
        $router->delete(
            '/{user}',
            ['as' => 'users.destroy', 'uses' => '\App\Http\Controllers\UserController@destroy']
        )
            ->middleware(
                'permission:delete.users'
            );
        $router->get(
            '/{user}',
            ['as' => 'users.show', 'uses' => '\App\Http\Controllers\UserController@show']
        );
        $router->get(
            '/{user}/edit',
            ['as' => 'users.edit', 'uses' => '\App\Http\Controllers\UserController@edit']
        )
            ->middleware(
                'permission:edit.users'
            );
        $router->get(
            '/search/coupons',
            [
                'as' => 'users.search.coupons',
                'uses' => '\App\Http\Controllers\UserController@searchRewardCoupons'
            ]
        )
            ->middleware(
                'permission:edit.users'
            );
        $router->get(
            '/search/employees/access',
            [
                'as' => 'users.search.employees.system.access',
                'uses' => '\App\Http\Controllers\UserController@searchAccessEmployees'
            ]
        )
            ->middleware(
                'permission:edit.users'
            );
        $router->get(
            '/search/clients/access',
            [
                'as' => 'users.search.clients.system.access',
                'uses' => '\App\Http\Controllers\UserController@searchAccessClients'
            ]
        )
            ->middleware(
                'permission:edit.users'
            );
        $router->get(
            '/search/users',
            [
                'as' => 'users.search',
                'uses' => '\App\Http\Controllers\UserController@searchUsers'
            ]
        );
    }
);

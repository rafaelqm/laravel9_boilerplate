<?php
// roles
$router->group(
    [
        'prefix' => 'roles',
        'middleware' => 'permission:roles.view',
    ],
    function () use ($router) {
        $router->get('', [
            \App\Http\Controllers\RoleController::class, 'index'
        ])->name('roles.index');

        $router->post(
            '',
            [
                'as' => 'roles.store',
                'uses' => '\App\Http\Controllers\RoleController@store'
            ]
        )
            ->middleware('permission:roles.create');
        $router->get(
            '/create',
            [
                'as' => 'roles.create',
                'uses' => '\App\Http\Controllers\RoleController@create'
            ]
        )
            ->middleware('permission:roles.create');
        $router->put(
            '/{id}',
            [
                'as' => 'roles.update',
                'uses' => '\App\Http\Controllers\RoleController@update'
            ]
        )
            ->middleware('permission:roles.edit');
        $router->patch(
            '/{id}',
            [
                'as' => 'roles.update',
                'uses' => '\App\Http\Controllers\RoleController@update'
            ]
        );
        $router->delete(
            '/{id}',
            [
                'as' => 'roles.destroy',
                'uses' => '\App\Http\Controllers\RoleController@destroy'
            ]
        )
            ->middleware('permission:roles.delete');
        $router->get(
            '/{id}',
            [
                'as' => 'roles.show',
                'uses' => '\App\Http\Controllers\RoleController@show'
            ]
        );
        $router->get(
            '/{id}/edit',
            [
                'as' => 'roles.edit',
                'uses' => '\App\Http\Controllers\RoleController@edit'
            ]
        )
            ->middleware('permission:roles.edit');
    }
);

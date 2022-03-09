<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Permission Types
         *
         */
        $Permissionitems = [
            [
                'name' => 'Pode visualizar usuários',
                'slug' => 'view.users',
                'description' => 'Pode visualizar usuários',
                'model' => 'Permission',
            ],
            [
                'name' => 'Pode criar novo usuário',
                'slug' => 'create.users',
                'description' => 'Pode criar novo usuário',
                'model' => 'Permission',
            ],
            [
                'name' => 'Pode editar usuários',
                'slug' => 'edit.users',
                'description' => 'Pode editar usuários',
                'model' => 'Permission',
            ],
            [
                'name' => 'Pode remover usuários',
                'slug' => 'delete.users',
                'description' => 'Pode remover usuários',
                'model' => 'Permission',
            ],
        ];

        /*
         * Add Permission Items
         *
         */
        foreach ($Permissionitems as $PermissionItem) {
            $newPermissionitem = config('roles.models.permission')::where('slug', '=', $PermissionItem['slug'])->first(
            );
            if ($newPermissionitem === null) {
                config('roles.models.permission')::create(
                    [
                        'name' => $PermissionItem['name'],
                        'slug' => $PermissionItem['slug'],
                        'description' => $PermissionItem['description'],
                        'model' => $PermissionItem['model'],
                    ]
                );
            }
        }
    }
}

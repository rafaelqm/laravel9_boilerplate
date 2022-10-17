<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
         * Role Types
         *
         */
        $RoleItems = [
            [
                'id' => Role::ADMIN_ID,
                'name' => 'Admin',
                'slug' => Role::ADMIN,
                'description' => 'Administrador geral',
                'level' => 5,
            ],
            [
                'id' => Role::GERENTE_ID,
                'name' => 'Usuário padrão',
                'slug' => Role::GERENTE,
                'description' => 'Todas as permissões exceto editar usuários',
                'level' => 2,
            ],
            [
                'id' => Role::VISITANTE_ID,
                'name' => 'Visitante',
                'slug' => Role::VISITANTE,
                'description' => 'Visitante',
                'level' => 0,
            ],
        ];

        /*
         * Add Role Items
         *
         */
        DB::table('roles')->delete();

        foreach ($RoleItems as $RoleItem) {
            $newRoleItem = Role::where('slug', '=', $RoleItem['slug'])->first();
            if ($newRoleItem === null) {
                DB::table('roles')->insert(
                    [
                        'id' => $RoleItem['id'],
                        'name' => $RoleItem['name'],
                        'slug' => $RoleItem['slug'],
                        'description' => $RoleItem['description'],
                        'level' => $RoleItem['level'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                        'active' => 1,
                    ]
                );
            }
        }
    }
}

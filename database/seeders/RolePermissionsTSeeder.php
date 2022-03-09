<?php

    namespace Database\Seeders;

    use App\Models\Permission;
    use App\Models\Role;
    use Illuminate\Database\Seeder;

    class RolePermissionsTSeeder extends Seeder {
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run() {
            /*
             * Permission Types
             *
             */
            config('roles.models.permission')::where('slug', 'LIKE', 'roles.%')->forceDelete();
            config('roles.models.permission')::where('slug', 'LIKE', '%.users')->forceDelete();

            $Permissionitems = [
                // Usuários
                [
                    'name' => 'Visualizar usuários',
                    'slug' => 'view.users',
                    'description' => 'Visualizar usuários',
                    'model' => 'Permission',
                ],
                [
                    'name' => 'Criar novo usuário',
                    'slug' => 'create.users',
                    'description' => 'Criar novo usuário',
                    'model' => 'Permission',
                ],
                [
                    'name' => 'Editar usuário',
                    'slug' => 'edit.users',
                    'description' => 'Editar usuário',
                    'model' => 'Permission',
                ],
                [
                    'name' => 'Remover usuário',
                    'slug' => 'delete.users',
                    'description' => 'Remover usuário',
                    'model' => 'Permission',
                ],
                // Papéis
                [
                    'name' => 'Visualizar papéis',
                    'slug' => 'roles.view',
                    'description' => 'Visualizar papéis',
                    'model' => 'Permission',
                ],
                [
                    'name' => 'Criar novo papel',
                    'slug' => 'roles.create',
                    'description' => 'Criar novo papel',
                    'model' => 'Permission',
                ],
                [
                    'name' => 'Editar papéis',
                    'slug' => 'roles.edit',
                    'description' => 'Editar papéis',
                    'model' => 'Permission',
                ],
                [
                    'name' => 'Remover papéis',
                    'slug' => 'roles.delete',
                    'description' => 'Remover papéis',
                    'model' => 'Permission',
                ],
            ];

            /*
             * Add Permission Items
             *
             */
            foreach ($Permissionitems as $Permissionitem) {
                $newPermissionitem = config('roles.models.permission')::where('slug', '=', $Permissionitem['slug'])->first();
                if ($newPermissionitem === null) {
                    config('roles.models.permission')::create(
                        [
                            'name' => $Permissionitem['name'],
                            'slug' => $Permissionitem['slug'],
                            'description' => $Permissionitem['description'],
                            'model' => $Permissionitem['model'],
                        ]
                    );
                }
            }
            $permissions = Permission::get();
            $roleAdmin = Role::where('slug', '=', 'admin')->first();
            foreach ($permissions as $permission) {
                $permission_role = $roleAdmin->permissions()->where('permission_id', $permission->id)->first();
                if (!$permission_role) {
                    $roleAdmin->attachPermission($permission);
                }
            }
        }
    }

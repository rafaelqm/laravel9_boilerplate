<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConnectRSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Get Available Permissions.
         */
        $permissions = config('roles.models.permission')::all();

        /**
         * Attach Permissions to Role Admin
         */
        $roleAdmin = config('roles.models.role')::where('name', '=', 'Admin')->first();
        foreach ($permissions as $permission) {
            $roleAdmin->attachPermission($permission);
        }
    }
}

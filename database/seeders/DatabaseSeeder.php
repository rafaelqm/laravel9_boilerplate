<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionsTSeeder::class);
        $this->call(RolesTSeeder::class);
//        $this->call(ConnectRSeeder::class);
        $this->call(UsersTSeeder::class);
        $this->call(RolePermissionsTSeeder::class);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = config('roles.models.role')::where('slug', '=', 'admin')->first();

        $admin = User::firstOrCreate([
            'name' => 'Admin',
            'email' => 'admin@admin.com'
        ], [
            'password' => bcrypt('admin'),
        ]);

        $admin->attachRole($adminRole);
    }
}

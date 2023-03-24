<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        $this->call([
            RolePermissionsSeeder::class,
            DepartmentsSeeder::class,
            CategoriesSeeder::class,
        ]);

        $user->assignRole(\Spatie\Permission\Models\Role::find(1));
        $user->departments()->sync(\App\Models\Department::all()->pluck('id')->toArray());
    }
}

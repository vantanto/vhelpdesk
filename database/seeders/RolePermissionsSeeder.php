<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('role_has_permissions')->truncate();
        DB::table('roles')->truncate();
        Schema::enableForeignKeyConstraints();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        

        // ===== Permissions ===== //
        $oldPermissions  = Permission::all()->pluck('name')->toArray();
        $arrayOfPermissionNames = [
            // Category
            'category-list', 'category-create', 'category-edit', 'category-delete',
            // Department
            'department-list', 'department-create', 'department-edit', 'department-delete',
            // User
            'user-list', 'user-create', 'user-detail', 'user-edit', 'user-delete',
            // Role
            'role-list', 'role-detail',
        ];


        $permissions = collect(array_diff($arrayOfPermissionNames, $oldPermissions))->map(function ($permission) {
            return ['name' => $permission, 'guard_name' => 'web'];
        });
        Permission::insert($permissions->toArray());
        // ===== Permissions ===== //


        // ===== Role Permissions ===== //
        $rolePermissions = [
            'Super Admin' => Permission::all(),
            'Admin' => [
                // Category
                'category-list', 'category-create', 'category-edit', 'category-delete',
                // Department
                'department-list', 'department-create', 'department-edit', 'department-delete',
                // User
                'user-list', 'user-create', 'user-detail',
                // Role
                'role-list', 'role-detail',
            ],
            'Supervisor' => [
                // Category
                'category-list',
                // Department
                'department-list',
                // User
                'user-list', 'user-detail',
            ],
            'User' => [

            ],
        ];

        foreach ($rolePermissions as $role=>$permissions) {
            Role::create(['name' => $role])->givePermissionTo($permissions);
        }
        // ===== Role Permissions ===== //
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        // $permissions = [
        //     'category-create',
        //     'category-edit',
        //     'category-delete',
        //     'category-publish',
        //     'subcategory-create',
        //     'subcategory-edit',
        //     'subcategory-delete',
        //     'subcategory-publish',
        //     'user-create',
        //     'user-edit',
        //     'user-delete',
        //     'user-publish',
        //     'role-create',
        //     'role-edit',
        //     'role-delete',
        //     'role-publish',
        //     'permission-create',
        //     'permission-edit',
        //     'permission-delete',
        //     'permission-publish',
        //     'setting',
        //  ];
       
        //  foreach ($permissions as $permission) {
        //       Permission::create(['name' => $permission]);
        //  }

        // $admin_role = 'CEO';
        // $admin = User::find(1);
        // $admin->assignRole($admin_role);
        // $role = Role::findByName($admin_role);
        // $role->syncPermissions($permissions);
    }
}

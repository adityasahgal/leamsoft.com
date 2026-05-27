<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $modules = [
            'banner', 'service', 'gallery', 'blog',
            'category', 'subcategory',
            'user', 'role', 'permission',
        ];
        $actions = ['create', 'edit', 'delete', 'publish'];

        $permissionNames = [];
        foreach ($modules as $module) {
            foreach ($actions as $action) {
                $permissionNames[] = "{$module}-{$action}";
            }
        }
        $permissionNames[] = 'enquiry-read';
        $permissionNames[] = 'general-setting';
        $permissionNames[] = 'setting';

        foreach ($permissionNames as $name) {
            Permission::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $ceo        = Role::firstOrCreate(['name' => 'CEO',         'guard_name' => 'web']);

        $superAdmin->syncPermissions(Permission::all());
        $ceo->syncPermissions(Permission::all());

        $superAdminEmails = [
            'adityasahagal399@gmail.com',
        ];

        foreach ($superAdminEmails as $email) {
            $user = User::where('email', $email)->first();

            if (! $user) {
                $user = User::create([
                    'name'     => 'Super Admin',
                    'email'    => $email,
                    'password' => Hash::make('password'),
                ]);
            }

            if (! $user->hasRole('Super Admin')) {
                $user->assignRole('Super Admin');
            }
            if (! $user->hasRole('CEO')) {
                $user->assignRole('CEO');
            }
            $user->syncPermissions(Permission::all());

            $this->command->info("Granted Super Admin + CEO + all {$user->getAllPermissions()->count()} permissions to user #{$user->id} ({$user->email}).");
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Super Admin']);
        $admin = Role::create(['name' => 'Admin']);
        $user = Role::create(['name' => 'User']);

        $admin->givePermissionTo([
            'create-warehouse',
            'edit-warehouse',
            'delete-warehouse',
            'create-purchase',
            'edit-purchase',
            'delete-purchase',
            'create-sale',
            'edit-sale',
            'delete-sale',
        ]);
        $user->givePermissionTo([
            'create-purchase',
            'edit-purchase',
            'delete-purchase',
            'create-sale',
            'edit-sale',
            'delete-sale',
            
        ]);
    }
}

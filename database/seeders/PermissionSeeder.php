<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
             // Reset cached roles and permissions
             app()[PermissionRegistrar::class]->forgetCachedPermissions();
        Permission::create(['name'=>'create branch']);
        Permission::create(['name'=>'delete branch']);
        $role = Role::create(['name'=>'admin']);
        $role->givePermissionTo('create branch');

        $role = Role::create(['name'=>'user']);
        $role->givePermissionTo('delete branch');

    }
}

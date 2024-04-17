<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-branch',
            'edit-branch',
            'delete-branch',
            'create-category',
            'edit-category',
            'delete-category',
            'create-unit',
            'edit-unit',
            'delete-unit',
            'create-product',
            'edit-product',
            'delete-product',
            'create-warehouse',
            'edit-warehouse',
            'delete-warehouse',
            'create-contact',
            'edit-contact',
            'delete-contact',
            'create-user',
            'edit-user',
            'delete-user',
            'create-purchase',
            'edit-purchase',
            'delete-purchase',
            'create-sale',
            'edit-sale',
            'delete-sale',
            
         ];
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
          }
    }
}

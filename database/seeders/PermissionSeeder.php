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
            'view-branch',
            'create-branch',
            'edit-branch',
            'delete-branch',
            'view-category',
            'create-category',
            'edit-category',
            'delete-category',
            'view-unit',
            'create-unit',
            'edit-unit',
            'delete-unit',
            'view-product',
            'create-product',
            'edit-product',
            'delete-product',
            'view-warehouse',
            'create-warehouse',
            'edit-warehouse',
            'delete-warehouse',
            'view-contact',
            'create-contact',
            'edit-contact',
            'delete-contact',
            'view-user',
            'create-user',
            'edit-user',
            'delete-user',
            'view-purchase',
            'create-purchase',
            'edit-purchase',
            'delete-purchase',
            'view-sale',
            'create-sale',
            'edit-sale',
            'delete-sale',
            'view-role',
            'create-role',
            'edit-role',
            'delete-role',
           
            
         ];
         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
          }
    }
}

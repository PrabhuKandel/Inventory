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
        $headquarterAdmin = Role::create(['name' => 'Headquarter Admin']);
        $headquarterUser = Role::create(['name' => 'Headquarter User']);
        $branchAdmin = Role::create(['name' => 'Branch Admin']);
        $branchUser = Role::create(['name' => 'Branch User']);

        $headquarterAdmin->givePermissionTo([
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
            

        ]);
      
        $headquarterUser->givePermissionTo([
            'view-branch',
            'create-branch',
            'edit-branch',
            'view-category',
            'create-category',
            'edit-category',
            'view-unit',
            'create-unit',
            'edit-unit',
            'view-product',
            'create-product',
            'edit-product',
            'view-warehouse',
            'create-warehouse',
            'edit-warehouse',
            'delete-warehouse',
            'view-contact',
            'create-contact',
            'edit-contact',
            'view-user',
            'view-purchase',
            'create-purchase',
            'edit-purchase',
            'delete-purchase',
            'view-sale',
            'create-sale',
            'edit-sale',
            'delete-sale',
            'view-role',
            
        ]);

        $branchAdmin->givePermissionTo([
            'view-branch',
            'view-category',
            'view-unit',
            'view-product',
            'view-warehouse',
            'create-warehouse',
            'edit-warehouse',
            'delete-warehouse',
            'view-contact',
            'view-user',
            'view-purchase',
            'create-purchase',
            'edit-purchase',
            'delete-purchase',
            'view-sale',
            'create-sale',
            'edit-sale',
            'delete-sale',
            
        ]);
        $branchUser->givePermissionTo([
            'view-category',
            'view-unit',
            'view-product',
            'view-warehouse',
            'view-contact',
            'view-user',
            'view-purchase',
            'create-purchase',
            'view-sale',
            'create-sale',
            
        ]);

        
    }
}

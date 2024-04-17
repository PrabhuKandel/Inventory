<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //superadmin

        $superAdmin = User::create([
            'name' => 'James', 
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('123'),
            'address'=>'kathmandu'
        ]);
        $superAdmin->assignRole('Super Admin');

        //creating admin
        $admin = User::create([
            'name' => 'Peter', 
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'address'=>'kathmandu'

        ]);
        $admin->assignRole('Admin');

        //creating user
        $user = User::create([
            'name' => 'Rony', 
            'email' => 'user@gmail.com',
            'password' => Hash::make('user'),
            'address'=>'kathmandu',
            
        ]);
        $user->assignRole('User');
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'first_name' => 'Admin',
            'middle_name' => 'M',
            'last_name' => 'User',
            'suffix' => '',
            'age' => 30,
            'date_of_birth' => '1994-01-01',
            'gender' => 'Male',
            'occupation' => 'Administrator',
            'civil_status' => 'Single',
            'cellphone_no' => '09123456789',
            'address' => 'Admin Street, Admin City',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
        ]);

        $admin->assignRole('Admin');
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin =User::firstOrCreate([
            'name' => 'Admin',
            'username' => 'Admin',
            'email' => 'admin@interpay.com',
            'phone' => '+923001234567',
            'password' => Hash::make('admin'),
        ]);

        $admin->assignRole(['admin']);

        $customer=User::firstOrCreate([
            'name' => 'User',
            'username' => 'User',
            'email' => 'user@interpay.com',
            'phone' => '+923001234568',
            'password' => Hash::make('12345678'),
        ]);

        $customer->assignRole(['user']);
    }
}

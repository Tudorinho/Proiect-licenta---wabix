<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {

        DB::table('users')->insert([
            'name' => 'admin',
            'dob' => '2000-10-10',
            'email' => 'hello@webitfactory.io',
            'password' => Hash::make('Password1!'),
            'email_verified_at' => '2023-12-06 09:53:33',
            'avatar' => 'images/avatar-1.jpg',
            'created_at' => now()
        ]);
    }
}

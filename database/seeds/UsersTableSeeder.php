<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Let's clear the users table first
        // User::truncate();

        // $faker = \Faker\Factory::create();

        // Let's make sure everyone has the same password and 
        // let's hash it before the loop, or else our seeder 
        // will be too slow.
        $password = Hash::make('123456');

            User::create([

                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => $password,
                'mobile' => '3265749874',
                'role' => 'admin',
                'status' => 'active',
            ]);

            // User::create([

            //     'name' => 'provider',
            //     'email' => 'provider@gmail.com',
            //     'password' => $password,
            //     'mobile' => '1326585489',
            //     'role' => 'admin',
            //     'status' => 'active',
            // ]);

           

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            [
                'name'=>'Admin User',
                'email'=>'admin@itsolutionstuff.com',
                'type'=>1,
                'password'=> bcrypt('123456'),
            ],
            [
                'name'=>'Manager User',
                'email'=>'manager@itsolutionstuff.com',
                'type'=> 2,
                'password'=> bcrypt('123456'),
            ],
            [
                'name'=>'User',
                'email'=>'user@itsolutionstuff.com',
                'type'=>0,
                'password'=> bcrypt('123456'),
            ],
        ];
        foreach ($users as $key => $user) {
            User::create($user);
        }

    }
}

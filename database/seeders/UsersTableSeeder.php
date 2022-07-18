<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array(
                'fname'=>'Admin',
                'lname'=>'Ainea',
                'email'=>'admin@gmail.com',
                'phone'=>'254716347332',
                'password'=>Hash::make('admin@123'),
                'role'=>'admin',
                'status'=>'active'
            ),
            array(
                'fname'=>'Obura',
                'lname'=>'User',
                'email'=>'user@gmail.com',
                'phone'=>'254716347332',
                'password'=>Hash::make('user@123'),
                'role'=>'user',
                'status'=>'active'
            ),
        );

        DB::table('users')->insert($data);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use DB;

class UserSeeder extends Seeder
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
            ),
            array(
                'fname'=>'Obura',
                'lname'=>'User',
                'email'=>'user@gmail.com',
                'phone'=>'254716347332',
                'password'=>Hash::make('user@123'),
                'role'=>'user',
            ),
        );

        DB::table('users')->insert($data);
    }
}

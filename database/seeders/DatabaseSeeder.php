<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'June Amante',
            'email' => 'admin@gmail.com',
            'usertype' => 'admin',
            'password' => Hash::make('letmein'),
        ]);
        DB::table('users')->insert([
            'name' => 'Jhon Doe',
            'email' => 'jhon@gmail.com',
            'usertype' => 'admin',
            'password' => Hash::make('letmein'),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 11; $i <= 30; $i++) {
            DB::table('users')->insert([
                'name' => 'Test' . $i,
                'email' => 'Test' . $i . '@email.com',
                'password' => bcrypt('password'),
            ]);
        }
    }
}

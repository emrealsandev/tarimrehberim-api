<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = bcrypt('123456');
        \App\Models\User::insert([
            'name'=>'Emre Alşan',
            'email'=>'admin@admin.com',
            'email_verified_at' => now(),
            'password' => $password, // 123456
            'remember_token' => Str::random(10),
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User as UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{

    public function run()
    {
        UserModel::factory(20)->create();

        UserModel::create([
            'name' => 'Qasim Salah',
            'username' => 'c9dx',
            'email' => 'q@gmail.com',
            'email_verified_at' => now(),
            'type' => UserType::Gold->value,
            'password' => bcrypt('q@gmail.com'),
            'remember_token' => Str::random(10),
        ]);
    }
}

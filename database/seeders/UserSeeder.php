<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'john@gmail.com'], // clé pour vérifier l'existence
            [
                'name' => 'John User',
                'password' => Hash::make('12345678'),
                'is_admin' => true, // marque l'utilisateur comme admin
            ]
        );
    }
}
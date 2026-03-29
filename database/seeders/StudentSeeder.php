<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        Student::create([
            'name' => 'Jean Dupont',
            'email' => 'jean@gmail.com',
            'phone' => '690000000',
            'program_id' => 1
        ]);

        Student::create([
            'name' => 'Marie Paul',
            'email' => 'marie@gmail.com',
            'phone' => '680000000',
            'program_id' => 2
        ]);

        Student::create([
            'name' => 'Kamal Tech',
            'email' => 'kamal@gmail.com',
            'phone' => '670000000',
            'program_id' => 3
        ]);
    }
}
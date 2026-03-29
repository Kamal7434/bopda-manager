<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramSeeder extends Seeder
{
    public function run(): void
    {
        Program::create(['name' => 'Génie logiciel']);
        Program::create(['name' => 'Systèmes et réseaux']);
        Program::create(['name' => 'Software engineering']);
    }
}
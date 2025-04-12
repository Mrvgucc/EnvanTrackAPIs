<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            'name' => 'test',
            'surname' => 'test',
            'email' => 'test@gmail.com',
            'phone' => '1234567890',
            'password' => Hash::make('1'),
            'status' => 'manager',
        ]);
    }
}

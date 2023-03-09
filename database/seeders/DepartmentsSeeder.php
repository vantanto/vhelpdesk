<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = ['Admin', 'Design', 'IT'];
        foreach ($departments as $department) {
            \App\Models\Department::create([
                'name' => $department
            ]);
        }
    }
}

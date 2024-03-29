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
        $departments = ['Accounting', 'Design', 'IT'];
        foreach ($departments as $department) {
            \App\Models\Department::create([
                'name' => $department
            ]);
        }

        \App\Models\User::find(1)->departments()->attach(1);
    }
}

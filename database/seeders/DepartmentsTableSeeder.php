<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            ['name' => 'Management', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'HumanResources', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Development', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Marketing', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Sales', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Operations', 'created_at' => now(), 'updated_at' => now(),],
            ['name' => 'Support', 'created_at' => now(), 'updated_at' => now(),],
        ]);

    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    const Management = 1;
    const HumanResources = 2;
    const Development = 3;
    const Marketing = 4;
    const Sales = 5;
    const Operations = 6;
    const Support = 7;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Roles for Management Department
        DB::table('roles')->insert([
            ['name' => 'MD', 'department_id' => self::Management, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CEO', 'department_id' => self::Management, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'COO', 'department_id' => self::Management, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CFO', 'department_id' => self::Management, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CTO', 'department_id' => self::Management, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'CMO', 'department_id' => self::Management, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'President', 'department_id' => self::Management, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Business Unit Head', 'department_id' => self::Management, 'created_at' => now(), 'updated_at' => now()],
        ]);
        // Roles for Human Resources Department
        DB::table('roles')->insert([
            ['name' => 'HOD (Head of Department)', 'department_id' => self::HumanResources, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HR Manager', 'department_id' => self::HumanResources, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Recruitment Specialist', 'department_id' => self::HumanResources, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Training and Development Manager', 'department_id' => self::HumanResources, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Employee Relations Manager', 'department_id' => self::HumanResources, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Compensation and Benefits Specialist', 'department_id' => self::HumanResources, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'HR Assistant', 'department_id' => self::HumanResources, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Payroll Administrator', 'department_id' => self::HumanResources, 'created_at' => now(), 'updated_at' => now()],
        ]);
        // Roles for Development Department
        DB::table('roles')->insert([
            ['name' => 'HOD (Head of Department)', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Design Manager', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Development Manager', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Design And Development Manager', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Frontend Developer', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Backend Developer', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Full Stack Developer', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mobile Developer', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'DevOps Engineer', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'QA Engineer', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Shopify Developer', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Wordpress Developer', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'ORM Executive', 'department_id' => self::Development, 'created_at' => now(), 'updated_at' => now()],
        ]);
        // Roles for Marketing Department
        DB::table('roles')->insert([
            ['name' => 'HOD (Head of Department)', 'department_id' => self::Marketing, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Digital Marketing Specialist', 'department_id' => self::Marketing, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'PPC Consultant', 'department_id' => self::Marketing, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SEO Executive', 'department_id' => self::Marketing, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Meta Marketing Manager', 'department_id' => self::Marketing, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Brand Manager', 'department_id' => self::Marketing, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'SMM Executive', 'department_id' => self::Marketing, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Content Writer', 'department_id' => self::Marketing, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Video Editor', 'department_id' => self::Marketing, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Creative Designer', 'department_id' => self::Marketing, 'created_at' => now(), 'updated_at' => now()],
        ]);
        // Roles for Sales Department
        DB::table('roles')->insert([
            ['name' => 'HOD (Head of Department)', 'department_id' => self::Sales, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Front Sales Executive', 'department_id' => self::Sales, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Up Sales Executive', 'department_id' => self::Sales, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sales Executive', 'department_id' => self::Sales, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sales Architect', 'department_id' => self::Sales, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Account Executive', 'department_id' => self::Sales, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sales and Support Coordinator', 'department_id' => self::Sales, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Brand Executive', 'department_id' => self::Sales, 'created_at' => now(), 'updated_at' => now()],
        ]);
        // Roles for Operations Department
        DB::table('roles')->insert([
            ['name' => 'HOD (Head of Department)', 'department_id' => self::Operations, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Operations Manager', 'department_id' => self::Operations, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Project Manager', 'department_id' => self::Operations, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Outsource Management Executive', 'department_id' => self::Operations, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Assistant Manager - Q/A', 'department_id' => self::Operations, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Q/A Analyst', 'department_id' => self::Operations, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'IT Executive', 'department_id' => self::Operations, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Finance', 'department_id' => self::Operations, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Office Administration', 'department_id' => self::Operations, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Accounts', 'department_id' => self::Operations, 'created_at' => now(), 'updated_at' => now()],
        ]);
        // Roles for Support Department
        DB::table('roles')->insert([
            ['name' => 'HOD (Head of Department)', 'department_id' => self::Support, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Support Staff', 'department_id' => self::Support, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Technician', 'department_id' => self::Support, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}

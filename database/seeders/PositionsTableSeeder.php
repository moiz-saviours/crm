<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionsTableSeeder extends Seeder
{
    // Constants for Role IDs
    const MD = 1;
    const CEO = 2;
    const COO = 3;
    const CFO = 4;
    const CTO = 5;
    const CMO = 6;
    const PRESIDENT = 7;
    const BUSINESS_UNIT_HEAD = 8;
    const HOD_HUMAN_RESOURCES = 9;
    const HR_MANAGER = 10;
    const RECRUITMENT_SPECIALIST = 11;
    const TRAINING_AND_DEVELOPMENT_MANAGER = 12;
    const EMPLOYEE_RELATIONS_MANAGER = 13;
    const COMPENSATION_AND_BENEFITS_SPECIALIST = 14;
    const HR_ASSISTANT = 15;
    const PAYROLL_ADMINISTRATOR = 16;
    const HOD_DEVELOPMENT = 17;
    const DESIGN_MANAGER = 18;
    const DEVELOPMENT_MANAGER = 19;
    const DESIGN_AND_DEVELOPMENT_MANAGER = 20;
    const FRONTEND_DEVELOPER = 21;
    const BACKEND_DEVELOPER = 22;
    const FULL_STACK_DEVELOPER = 23;
    const MOBILE_DEVELOPER = 24;
    const DEVOPS_ENGINEER = 25;
    const QA_ENGINEER = 26;
    const SHOPIFY_DEVELOPER = 27;
    const WORDPRESS_DEVELOPER = 28;
    const ORM_EXECUTIVE = 29;
    const HOD_MARKETING = 30;
    const DIGITAL_MARKETING_SPECIALIST = 31;
    const PPC_CONSULTANT = 32;
    const SEO_EXECUTIVE = 33;
    const META_MARKETING_MANAGER = 34;
    const BRAND_MANAGER = 35;
    const SMM_EXECUTIVE = 36;
    const CONTENT_WRITER = 37;
    const VIDEO_EDITOR = 38;
    const CREATIVE_DESIGNER = 39;
    const HOD_SALES = 40;
    const FRONT_SALES_EXECUTIVE = 41;
    const UP_SALES_EXECUTIVE = 42;
    const SALES_EXECUTIVE = 43;
    const SALES_ARCHITECT = 44;
    const ACCOUNT_EXECUTIVE = 45;
    const SALES_AND_SUPPORT_COORDINATOR = 46;
    const BRAND_EXECUTIVE = 47;
    const HOD_OPERATIONS = 48;
    const OPERATIONS_MANAGER = 49;
    const PROJECT_MANAGER = 50;
    const OUTSOURCE_MANAGEMENT_EXECUTIVE = 51;
    const ASSISTANT_MANAGER_QA = 52;
    const QA_ANALYST = 53;
    const IT_EXECUTIVE = 54;
    const FINANCE = 55;
    const OFFICE_ADMINISTRATION = 56;
    const ACCOUNTS = 57;
    const HOD_SUPPORT = 58;
    const SUPPORT_STAFF = 59;
    const TECHNICIAN = 60;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Positions for Management Roles (e.g., CEO, COO, CFO, etc.)
        $this->insertPositions(self::CEO, ['Associate', 'Assistant', 'Director', 'Partner']);
        // Positions for Human Resources Roles
        $this->insertSeniorJuniorInternPositions(self::HR_MANAGER);
        $this->insertSeniorJuniorInternPositions(self::RECRUITMENT_SPECIALIST);
        $this->insertSeniorJuniorInternPositions(self::TRAINING_AND_DEVELOPMENT_MANAGER);
        $this->insertSeniorJuniorInternPositions(self::EMPLOYEE_RELATIONS_MANAGER);
        $this->insertSeniorJuniorInternPositions(self::COMPENSATION_AND_BENEFITS_SPECIALIST);
        $this->insertSeniorJuniorInternPositions(self::HR_ASSISTANT);
        $this->insertSeniorJuniorInternPositions(self::PAYROLL_ADMINISTRATOR);
        // Positions for Development Roles
        $this->insertSeniorJuniorInternPositions(self::FRONTEND_DEVELOPER);
        $this->insertSeniorJuniorInternPositions(self::BACKEND_DEVELOPER);
        $this->insertSeniorJuniorInternPositions(self::FULL_STACK_DEVELOPER);
        $this->insertSeniorJuniorInternPositions(self::MOBILE_DEVELOPER);
        $this->insertSeniorJuniorInternPositions(self::DEVOPS_ENGINEER);
        $this->insertSeniorJuniorInternPositions(self::QA_ENGINEER);
        $this->insertSeniorJuniorInternPositions(self::SHOPIFY_DEVELOPER);
        $this->insertSeniorJuniorInternPositions(self::WORDPRESS_DEVELOPER);
        $this->insertSeniorJuniorInternPositions(self::ORM_EXECUTIVE);
        // Positions for Marketing Roles
        $this->insertSeniorJuniorInternPositions(self::DIGITAL_MARKETING_SPECIALIST);
        $this->insertSeniorJuniorInternPositions(self::PPC_CONSULTANT);
        $this->insertSeniorJuniorInternPositions(self::SEO_EXECUTIVE);
        $this->insertSeniorJuniorInternPositions(self::META_MARKETING_MANAGER);
        $this->insertSeniorJuniorInternPositions(self::BRAND_MANAGER);
        $this->insertSeniorJuniorInternPositions(self::SMM_EXECUTIVE);
        $this->insertSeniorJuniorInternPositions(self::CONTENT_WRITER);
        $this->insertSeniorJuniorInternPositions(self::VIDEO_EDITOR);
        $this->insertSeniorJuniorInternPositions(self::CREATIVE_DESIGNER);
        // Positions for Sales Roles
        $this->insertSeniorJuniorInternPositions(self::FRONT_SALES_EXECUTIVE);
        $this->insertSeniorJuniorInternPositions(self::UP_SALES_EXECUTIVE);
        $this->insertSeniorJuniorInternPositions(self::SALES_EXECUTIVE);
        $this->insertSeniorJuniorInternPositions(self::SALES_ARCHITECT);
        $this->insertSeniorJuniorInternPositions(self::ACCOUNT_EXECUTIVE);
        $this->insertSeniorJuniorInternPositions(self::SALES_AND_SUPPORT_COORDINATOR);
        $this->insertSeniorJuniorInternPositions(self::BRAND_EXECUTIVE);
        // Positions for Operations Roles
        $this->insertSeniorJuniorInternPositions(self::OPERATIONS_MANAGER);
        $this->insertSeniorJuniorInternPositions(self::PROJECT_MANAGER);
        $this->insertSeniorJuniorInternPositions(self::OUTSOURCE_MANAGEMENT_EXECUTIVE);
        $this->insertSeniorJuniorInternPositions(self::TECHNICIAN);
        $this->insertSeniorJuniorInternPositions(self::ASSISTANT_MANAGER_QA);
        $this->insertSeniorJuniorInternPositions(self::QA_ANALYST);
        $this->insertSeniorJuniorInternPositions(self::IT_EXECUTIVE);
        $this->insertSeniorJuniorInternPositions(self::FINANCE);
        $this->insertSeniorJuniorInternPositions(self::OFFICE_ADMINISTRATION);
        $this->insertSeniorJuniorInternPositions(self::ACCOUNTS);
        // Positions for Support Roles
        $this->insertSeniorJuniorInternPositions(self::SUPPORT_STAFF);
        $this->insertSeniorJuniorInternPositions(self::TECHNICIAN);
    }

    /**
     * Insert positions with SENIOR, JUNIOR, and INTERN levels.
     *
     * @param int $roleId
     */
    private function insertSeniorJuniorInternPositions(int $roleId): void
    {
        $this->insertPositions($roleId, ['Senior', 'Junior', 'Intern']);
    }

    /**
     * Insert positions for a given role.
     *
     * @param int $roleId
     * @param array $positions
     */
    private function insertPositions(int $roleId, array $positions): void
    {
        $data = array_map(function ($position) use ($roleId) {
            return ['name' => $position, 'role_id' => $roleId];
        }, $positions);
        DB::table('positions')->insert($data);
    }
}

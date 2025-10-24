<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Admin;
use App\Models\CustomerContact;
use App\Models\Team;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing records from related tables
        $brands = Brand::all();
        $customerContacts = CustomerContact::all();
        $teams = Team::all();
        $admins = Admin::all();

        if ($customerContacts->isEmpty()) {
            $this->command->error("No customer contacts found.");
            return;
        }

        if ($admins->isEmpty()) {
            $this->command->error("No admins found.");
            return;
        }

        // If no records exist, we'll use null/default values
        $teamIds = $teams->pluck('id')->toArray();

        $projects = [];
        $projectAttachments = [];
        $projectMembers = [];

        $projectCounter = 1;

        // 🔁 Create 50 projects for each customer
        foreach ($customerContacts as $customerContact) {
            for ($i = 1; $i <= 10; $i++) {

                // Randomly assign an admin as the creator
                $admin = $admins->random();

                // Get team_key sequentially
                $teamKey = null;
                if (!empty($teamIds)) {
                    $team = $teams[($projectCounter - 1) % count($teams)];
                    $teamKey = $team->team_key ?? 'TEAM-' . str_pad($team->id, 3, '0', STR_PAD_LEFT);
                }

                // Get brand_key (optional for now)
                $brandKey = null;

                // Prepare project record
                $projects[] = [
                    'special_key' => 'PROJ-' . str_pad($projectCounter, 6, '0', STR_PAD_LEFT) . '-' . uniqid(),
                    'cus_contact_key' => $customerContact->special_key ?? 'CUST-' . str_pad($customerContact->id, 4, '0', STR_PAD_LEFT),
                    'brand_key' => $brandKey,
                    'team_key' => $teamKey,
                    'type' => $this->getProjectType($projectCounter),
                    'value' => $this->getProjectValue($projectCounter),
                    'label' => 'Project ' . $projectCounter . ' - Customer ' . $customerContact->id,
                    'theme_color' => $this->getThemeColor($projectCounter),
                    'project_status' => $this->getProjectStatus($projectCounter),
                    'is_progress' => $projectCounter % 4 !== 0,
                    'progress' => $this->getProgress($projectCounter),
                    'bill_type' => $this->getBillType($projectCounter),
                    'total_rate' => $this->getTotalRate($projectCounter),
                    'estimated_hours' => $this->getEstimatedHours($projectCounter),
                    'start_date' => $this->getStartDate($projectCounter),
                    'deadline' => $this->getDeadline($projectCounter),
                    'tags' => json_encode($this->getTags($projectCounter)),
                    'description' => $this->getDescription($projectCounter) . ' (For Customer ' . $customerContact->id . ')',
                    'is_notify' => $projectCounter % 5 !== 0,
                    'creator_type' => 'App\Models\Admin',
                    'creator_id' => $admin->id,
                    'status' => $projectCounter % 100 === 0 ? 0 : 1, // Every 100th project is inactive
                    'created_at' => Carbon::now()->subDays(rand(0, 365)),
                    'updated_at' => Carbon::now()->subDays(rand(0, 365)),
                ];

                $projectCounter++;
            }
        }

        // Insert all projects
        DB::table('projects')->insert($projects);
        $insertedProjects = Project::all();

        // 🔗 Create attachments and members for each project
        foreach ($insertedProjects as $index => $project) {
            // Attachments (2–4 per project)
            $attachmentCount = rand(2, 4);
            for ($j = 1; $j <= $attachmentCount; $j++) {
                $projectAttachments[] = [
                    'project_id' => $project->id,
                    'file_name' => $this->getFileName($index + 1, $j),
                    'file_path' => $this->getFilePath($index + 1, $j),
                    'file_type' => $this->getFileType($j),
                    'file_size' => rand(1024, 10485760),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            // Members (3–5 per project)
            $memberCount = rand(3, 5);
            $usedMemberIds = [$project->creator_id];

            // Add creator as Project Manager
            $projectMembers[] = [
                'project_id' => $project->id,
                'member_type' => 'App\Models\Admin',
                'member_id' => $project->creator_id,
                'role' => 'Project Manager',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // Add additional random admins
            for ($k = 2; $k <= $memberCount; $k++) {
                $memberId = $this->getMemberId($admins, $k, $usedMemberIds);
                $usedMemberIds[] = $memberId;

                $projectMembers[] = [
                    'project_id' => $project->id,
                    'member_type' => 'App\Models\Admin',
                    'member_id' => $memberId,
                    'role' => $this->getMemberRole($k),
                    'is_active' => $k !== $memberCount,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        // Insert attachments and members
        DB::table('project_attachments')->insert($projectAttachments);
        DB::table('project_members')->insert($projectMembers);

        $this->command->info('Created ' . count($projects) . ' projects (' . $customerContacts->count() . ' customers × 50 projects each)');
        $this->command->info('Created ' . count($projectAttachments) . ' project attachments');
        $this->command->info('Created ' . count($projectMembers) . ' project member assignments');
    }


    private function getFileName(int $projectIndex, int $attachmentIndex): string
    {
        $fileTypes = [
            'project_document',
            'requirements_spec',
            'design_mockup',
            'technical_diagram',
            'contract_agreement'
        ];
        
        $type = $fileTypes[($attachmentIndex - 1) % count($fileTypes)];
        return "project_{$projectIndex}_{$type}_{$attachmentIndex}.pdf";
    }

    private function getFilePath(int $projectIndex, int $attachmentIndex): string
    {
        return "projects/project_{$projectIndex}/attachments/attachment_{$attachmentIndex}.pdf";
    }

    private function getFileType(int $attachmentIndex): string
    {
        $types = ['application/pdf', 'image/png', 'image/jpeg', 'application/msword', 'application/vnd.ms-excel'];
        return $types[($attachmentIndex - 1) % count($types)];
    }

    private function getMemberId($admins, int $memberIndex, array $usedMemberIds)
    {
        if ($admins->isNotEmpty()) {
            $availableAdmins = $admins->whereNotIn('id', $usedMemberIds);
            if ($availableAdmins->isNotEmpty()) {
                return $availableAdmins->random()->id;
            }
            // If all admins are used, pick a random one (avoid duplicates where possible)
            return $admins->random()->id;
        }
        return $memberIndex;
    }

    private function getMemberRole(int $memberIndex): string
    {
        $roles = ['Developer', 'Designer', 'QA Tester', 'Business Analyst', 'Technical Lead'];
        return $roles[($memberIndex - 2) % count($roles)]; // Start from index 2 since PM is already assigned
    }

    private function getProjectType(int $index): string
    {
        $types = ['web_development', 'mobile_app', 'design', 'marketing', 'consulting', 'ecommerce', 'api_development', 'maintenance'];
        return $types[($index - 1) % count($types)];
    }

    private function getProjectValue(int $index): string
    {
        $values = ['regular', 'standard', 'premium', 'exclusive'];
        return $values[($index - 1) % count($values)];
    }

    private function getThemeColor(int $index): string
    {
        $colors = ['#3B82F6', '#10B981', '#EF4444', '#F59E0B', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'];
        return $colors[($index - 1) % count($colors)];
    }

    private function getProjectStatus(int $index): string
    {
        $statuses = ['is_progress', 'on_hold', 'cancelled', 'finished'];
        return $statuses[($index - 1) % count($statuses)];
    }

    private function getProgress(int $index): int
    {
        $status = $this->getProjectStatus($index);
        return match($status) {
            'finished' => 100,
            'cancelled' => rand(0, 50),
            'on_hold' => rand(20, 80),
            'planning' => rand(0, 20),
            'review' => rand(80, 95),
            default => rand(0, 95)
        };
    }

    private function getBillType(int $index): string
    {
        $billTypes = ['fix rate', 'project_hours', 'task_hours'];
        return $billTypes[($index - 1) % count($billTypes)];
    }

    private function getTotalRate(int $index): float
    {
        $rates = [1500.00, 2500.50, 5000.00, 7500.75, 10000.00, 15000.00, 20000.00, 25000.00, 35000.00, 50000.00, 75000.00, 100000.00];
        return $rates[($index - 1) % count($rates)];
    }

    private function getEstimatedHours(int $index): float
    {
        $hours = [50.0, 80.5, 120.0, 200.0, 150.5, 300.0, 250.0, 400.0, 350.5, 500.0, 600.0, 750.0];
        return $hours[($index - 1) % count($hours)];
    }

    private function getStartDate(int $index): Carbon
    {
        return Carbon::now()->subDays(($index * 7) + rand(1, 30));
    }

    private function getDeadline(int $index): Carbon
    {
        return Carbon::now()->addDays(($index * 10) + rand(30, 180));
    }

    private function getTags(int $index): array
    {
        $tagSets = [
            ['urgent', 'development', 'web'],
            ['design', 'ui/ux', 'responsive'],
            ['marketing', 'seo', 'social-media'],
            ['mobile', 'ios', 'android', 'flutter'],
            ['web', 'responsive', 'frontend'],
            ['ecommerce', 'payment', 'woocommerce'],
            ['api', 'integration', 'rest'],
            ['analytics', 'tracking', 'data'],
            ['security', 'authentication', 'ssl'],
            ['cloud', 'deployment', 'aws'],
            ['maintenance', 'support', 'updates'],
            ['consulting', 'strategy', 'planning']
        ];

        return $tagSets[($index - 1) % count($tagSets)];
    }

    private function getDescription(int $index): string
    {
        $descriptions = [
            'Website development project with modern technologies and responsive design.',
            'Mobile application development for both iOS and Android platforms.',
            'UI/UX design project focusing on user experience and interface design.',
            'Digital marketing campaign with SEO optimization and social media integration.',
            'Business consulting project for process optimization and efficiency improvement.',
            'E-commerce platform development with payment gateway integration.',
            'API development and integration services for third-party systems.',
            'Data analytics and tracking implementation for business intelligence.',
            'Security enhancement project with authentication system implementation.',
            'Cloud deployment and infrastructure setup for scalable applications.',
            'Ongoing maintenance and support services for existing systems.',
            'Strategic consulting and planning for digital transformation.'
        ];

        return $descriptions[($index - 1) % count($descriptions)];
    }
}
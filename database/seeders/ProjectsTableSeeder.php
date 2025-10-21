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

        // If no records exist, we'll use null/default values
        $brandIds = $brands->pluck('id')->toArray();
        $customerContactIds = $customerContacts->pluck('id')->toArray();
        $teamIds = $teams->pluck('id')->toArray();
        
        $projects = [];
        $projectAttachments = [];
        $projectMembers = [];

        for ($i = 1; $i <= 10; $i++) {
            // Determine brand_id - assign to existing brands sequentially
            $brandId = null;
            if (!empty($brandIds)) {
                $brandId = $brandIds[($i - 1) % count($brandIds)];
            }

            // Get customer_special_key from CustomerContact sequentially
            $customerSpecialKey = null;
            if (!empty($customerContactIds)) {
                $customerContact = $customerContacts[($i - 1) % count($customerContacts)];
                $customerSpecialKey = $customerContact->special_key ?? 'CUST-' . str_pad($customerContact->id, 4, '0', STR_PAD_LEFT);
            }

            // Get team_key from Team model sequentially
            $teamKey = null;
            if (!empty($teamIds)) {
                $team = $teams[($i - 1) % count($teams)];
                $teamKey = $team->team_key ?? 'TEAM-' . str_pad($team->id, 3, '0', STR_PAD_LEFT);
            }

            // Get brand_key from Brand model sequentially
            $brandKey = null;
            if ($brandId && !empty($brands)) {
                $brand = $brands->firstWhere('id', $brandId);
                $brandKey = $brand->brand_key ?? 'BRAND-' . str_pad($brandId, 3, '0', STR_PAD_LEFT);
            }

            // Determine creator - use Admin with first available ID or authenticated user
            $creatorType = 'App\Models\Admin';
            $creatorId = null;
            
            if ($admins->isNotEmpty()) {
                $creatorId = $admins->first()->id; // Use first admin instead of random
            } else {
                // Fallback to authenticated user or default
                $creatorId = Auth::id() ?? 1;
            }

            $projects[] = [
                'brand_id' => $brandId,
                'special_key' => 'PROJ-' . str_pad($i, 6, '0', STR_PAD_LEFT) . '-' . uniqid(),
                'customer_special_key' => $customerSpecialKey,
                'brand_key' => $brandKey,
                'team_key' => $teamKey,
                'type' => $this->getProjectType($i),
                'value' => $this->getProjectValue($i),
                'label' => 'Project Label ' . $i,
                'theme_color' => $this->getThemeColor($i),
                'project_status' => $this->getProjectStatus($i),
                'is_progress' => $i % 4 !== 0,
                'progress' => $this->getProgress($i),
                'bill_type' => $this->getBillType($i),
                'total_rate' => $this->getTotalRate($i),
                'estimated_hours' => $this->getEstimatedHours($i),
                'start_date' => $this->getStartDate($i),
                'deadline' => $this->getDeadline($i),
                'tags' => json_encode($this->getTags($i)),
                'description' => $this->getDescription($i),
                'is_notify' => $i % 5 !== 0,
                'creator_type' => $creatorType,
                'creator_id' => $creatorId,
                'status' => $i === 10 ? 0 : 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        }

        // Insert projects and get their IDs
        DB::table('projects')->insert($projects);
        $insertedProjects = Project::all();

        // Create attachments and members for each project
        foreach ($insertedProjects as $index => $project) {
            // Create 2-4 attachments per project
            $attachmentCount = rand(2, 4);
            for ($j = 1; $j <= $attachmentCount; $j++) {
                $projectAttachments[] = [
                    'project_id' => $project->id,
                    'file_name' => $this->getFileName($index + 1, $j),
                    'file_path' => $this->getFilePath($index + 1, $j),
                    'file_type' => $this->getFileType($j),
                    'file_size' => rand(1024, 10485760), // 1KB to 10MB
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }

            // Create 3-5 members per project
            $memberCount = rand(3, 5);
            $usedMemberIds = []; // Track used member IDs for uniqueness
            
            for ($k = 1; $k <= $memberCount; $k++) {
                $memberType = 'App\Models\Admin';
                $memberId = $this->getMemberId($admins, $k, $usedMemberIds);
                $usedMemberIds[] = $memberId;

                $projectMembers[] = [
                    'project_id' => $project->id,
                    'member_type' => $memberType,
                    'member_id' => $memberId,
                    'role' => $this->getMemberRole($k),
                    'is_active' => $k !== $memberCount, // Last member is inactive for demo
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        // Insert attachments and members
        DB::table('project_attachments')->insert($projectAttachments);
        DB::table('project_members')->insert($projectMembers);
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
                return $availableAdmins->first()->id;
            }
            // If all admins are used, reuse the first one
            return $admins->first()->id;
        }
        return $memberIndex;
    }

    private function getMemberRole(int $memberIndex): string
    {
        $roles = ['Project Manager', 'Developer', 'Designer', 'QA Tester', 'Business Analyst'];
        return $roles[($memberIndex - 1) % count($roles)];
    }

    private function getProjectType(int $index): string
    {
        $types = ['web_development', 'mobile_app', 'design', 'marketing', 'consulting'];
        return $types[($index - 1) % count($types)];
    }

    private function getProjectValue(int $index): string
    {
        $values = ['regular', 'standard', 'premium', 'exclusive'];
        return $values[($index - 1) % count($values)];
    }

    private function getThemeColor(int $index): string
    {
        $colors = ['#3B82F6', '#10B981', '#EF4444', '#F59E0B', '#8B5CF6'];
        return $colors[($index - 1) % count($colors)];
    }

    private function getProjectStatus(int $index): string
    {
        $statuses = ['isprogress', 'on hold', 'cancelled', 'finished'];
        return $statuses[($index - 1) % count($statuses)];
    }

    private function getProgress(int $index): int
    {
        $status = $this->getProjectStatus($index);
        return match($status) {
            'finished' => 100,
            'cancelled' => rand(0, 50),
            'on hold' => rand(20, 80),
            default => rand(0, 95) // isprogress
        };
    }

    private function getBillType(int $index): string
    {
        $billTypes = ['fix rate', 'project_hours', 'task_hours'];
        return $billTypes[($index - 1) % count($billTypes)];
    }

    private function getTotalRate(int $index): float
    {
        $rates = [1500.00, 2500.50, 5000.00, 7500.75, 10000.00, 15000.00, 20000.00, 25000.00, 35000.00, 50000.00];
        return $rates[$index - 1] ?? 5000.00;
    }

    private function getEstimatedHours(int $index): float
    {
        $hours = [50.0, 80.5, 120.0, 200.0, 150.5, 300.0, 250.0, 400.0, 350.5, 500.0];
        return $hours[$index - 1] ?? 200.0;
    }

    private function getStartDate(int $index): Carbon
    {
        return Carbon::now()->subDays(($index * 10) + 5);
    }

    private function getDeadline(int $index): Carbon
    {
        return Carbon::now()->addDays(($index * 15) + 30);
    }

    private function getTags(int $index): array
    {
        $tagSets = [
            ['urgent', 'development'],
            ['design', 'ui/ux'],
            ['marketing', 'seo'],
            ['mobile', 'ios', 'android'],
            ['web', 'responsive'],
            ['ecommerce', 'payment'],
            ['api', 'integration'],
            ['analytics', 'tracking'],
            ['security', 'authentication'],
            ['cloud', 'deployment']
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
            'Cloud deployment and infrastructure setup for scalable applications.'
        ];

        return $descriptions[($index - 1) % count($descriptions)];
    }
}
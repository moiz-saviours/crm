<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Project;
use App\Models\Task;

class TasksTableSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $projects = Project::all();
            $admins = Admin::all();

            if ($projects->isEmpty()) {
                $this->command->error("No projects found. Please seed projects first.");
                return;
            }

            if ($admins->isEmpty()) {
                $this->command->error("No admins found.");
                return;
            }

            $this->command->info("Starting task creation process...");
            $totalTasks = 0;
            $totalAttachments = 0;
            $totalMembers = 0;
            $taskCounter = 1;

            foreach ($projects as $project) {
                $this->command->info("Processing Project: {$project->id} ({$project->label})");

                try {
                    // Create 5 tasks per project
                    for ($i = 1; $i <= 5; $i++) {
                        $creator = $admins->random();

                        $task = Task::create([
                            'project_id' => $project->id,
                            'special_key' => Task::generateSpecialKey(),
                            'task_status' => $this->getTaskStatus($taskCounter),
                            'label' => 'Task ' . $taskCounter . ' - Project ' . $project->id,
                            'description' => $this->getDescription($taskCounter),
                            'creator_type' => 'App\Models\Admin',
                            'creator_id' => $creator->id,
                            'status' => $taskCounter % 50 === 0 ? 0 : 1,
                            'created_at' => Carbon::now()->subDays(rand(0, 180)),
                            'updated_at' => Carbon::now()->subDays(rand(0, 180)),
                        ]);

                        $totalTasks++;
                        $this->command->line("Task #{$taskCounter}: {$task->label} (ID: {$task->id})");

                        // Create 2 attachments for each task
                        $attachments = [];
                        for ($j = 1; $j <= 2; $j++) {
                            $attachment = [
                                'task_id' => $task->id,
                                'file_name' => $this->getFileName($taskCounter, $j),
                                'file_path' => $this->getFilePath($taskCounter, $j),
                                'file_type' => $this->getFileType($j),
                                'file_size' => rand(1024, 2048000),
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ];
                            DB::table('task_attachments')->insert($attachment);
                            $attachments[] = $attachment['file_name'];
                            $totalAttachments++;
                        }

                        $this->command->line("   📎 Attachments: " . implode(', ', $attachments));

                        // Add members for this task (3–5 random admins)
                        $memberCount = rand(3, 5);
                        $usedMemberIds = [$creator->id];
                        $memberRoles = [];

                        // Add creator as Task Lead
                        DB::table('task_members')->insert([
                            'task_id' => $task->id,
                            'member_type' => 'App\Models\Admin',
                            'member_id' => $creator->id,
                            'role' => 'Task Lead',
                            'is_active' => true,
                            'creator_type' => 'App\Models\Admin',
                            'creator_id' => $creator->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                        $memberRoles[] = 'Task Lead';
                        $totalMembers++;

                        for ($k = 2; $k <= $memberCount; $k++) {
                            $memberId = $this->getMemberId($admins, $usedMemberIds);
                            $usedMemberIds[] = $memberId;
                            $role = $this->getMemberRole($k);

                            DB::table('task_members')->insert([
                                'task_id' => $task->id,
                                'member_type' => 'App\Models\Admin',
                                'member_id' => $memberId,
                                'role' => $role,
                                'is_active' => $k !== $memberCount,
                                'creator_type' => 'App\Models\Admin',
                                'creator_id' => $creator->id,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                            $memberRoles[] = $role;
                            $totalMembers++;
                        }

                        $this->command->line("   👥 Members: {$memberCount} (" . implode(', ', array_unique($memberRoles)) . ")");
                        $taskCounter++;
                    }

                    $this->command->info("✅ Completed Project: {$project->id}");
                    $this->command->line("");

                } catch (\Throwable $e) {
                    $this->command->error("Error creating tasks for Project ID {$project->id}: " . $e->getMessage());
                    continue;
                }
            }

            // Final summary
            $this->command->info("TASK SEEDING COMPLETED!");
            $this->command->info("=================================");
            $this->command->info("Total Tasks: {$totalTasks}");
            $this->command->info("Total Attachments: {$totalAttachments}");
            $this->command->info("Total Members: {$totalMembers}");
            $this->command->info("Attachments per task: " . number_format($totalAttachments / $totalTasks, 2));
            $this->command->info("Members per task: " . number_format($totalMembers / $totalTasks, 2));
            $this->command->info("=================================");

        } catch (\Throwable $e) {
            $this->command->error('Seeder stopped due to error: ' . $e->getMessage());
        }
    }

    private function getTaskStatus(int $index): string
    {
        $statuses = ['is_progress', 'on_hold', 'cancelled', 'finished'];
        return $statuses[($index - 1) % count($statuses)];
    }

    private function getDescription(int $index): string
    {
        $descriptions = [
            'Implement main functionality and integrate modules.',
            'Fix reported bugs and perform QA testing.',
            'Prepare UI screens and frontend improvements.',
            'Coordinate API integration and backend logic.',
            'Conduct code review and performance optimization.',
            'Deploy to staging environment and test final flow.',
        ];
        return $descriptions[($index - 1) % count($descriptions)];
    }

    private function getFileName(int $taskIndex, int $attachmentIndex): string
    {
        $types = ['task_doc', 'screenshot', 'report', 'test_case', 'notes'];
        $type = $types[($attachmentIndex - 1) % count($types)];
        return "task_{$taskIndex}_{$type}_{$attachmentIndex}.pdf";
    }

    private function getFilePath(int $taskIndex, int $attachmentIndex): string
    {
        return "tasks/task_{$taskIndex}/attachments/attachment_{$attachmentIndex}.pdf";
    }

    private function getFileType(int $attachmentIndex): string
    {
        $types = ['application/pdf', 'image/png', 'image/jpeg', 'application/msword'];
        return $types[($attachmentIndex - 1) % count($types)];
    }

    private function getMemberId($admins, array $usedIds)
    {
        $available = $admins->whereNotIn('id', $usedIds);
        if ($available->isNotEmpty()) {
            return $available->random()->id;
        }
        return $admins->random()->id;
    }

    private function getMemberRole(int $index): string
    {
        $roles = ['Developer', 'QA Tester', 'UI Designer', 'Business Analyst'];
        return $roles[($index - 2) % count($roles)];
    }
}

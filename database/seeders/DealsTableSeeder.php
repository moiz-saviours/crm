<?php

namespace Database\Seeders;

use App\Models\Deal;
use App\Models\CustomerCompany;
use App\Models\CustomerContact;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DealsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing records
        $this->command->info('Clearing existing deals...');
        Deal::truncate();
        $this->command->info('Existing deals cleared.');

        // Get available companies, contacts, and users
        $this->command->info('Fetching related data...');
        $companies = CustomerCompany::where('status', 1)->get();
        $contacts = CustomerContact::where('status', 1)->get();
        $users = User::where('status', 1)->get();
        
        $this->command->info("Found {$companies->count()} companies, {$contacts->count()} contacts, {$users->count()} users");

        $dealStages = [1, 2, 3, 4, 5, 6, 7];
        $priorities = ['low', 'medium', 'high'];
        $dealTypes = ['New Business', 'Existing Business', 'Renewal', 'Upsell', 'Partnership'];
        $services = [1, 2, 3, 4, 5, 6]; // Updated service IDs

        $this->command->info('Starting to create deals one by one...');

        for ($i = 1; $i <= 20; $i++) {
            $this->command->info("Creating deal {$i}/20...");
            
            $company = $companies->random();
            $contact = $contacts->random();
            $user = $users->random();
            
            $amount = rand(1000, 100000);
            $startDate = now()->subDays(rand(1, 60));
            $closeDate = now()->addDays(rand(1, 90));
            $dealStage = $dealStages[array_rand($dealStages)];
            $priority = $priorities[array_rand($priorities)];
            $dealType = $dealTypes[array_rand($dealTypes)];
            $service = $services[array_rand($services)]; // Random service from 1-6

            $dealName = $this->generateDealName($i, $company->name, $dealType);
            
            $this->command->info("Deal {$i}: {$dealName}");
            $this->command->info("  - Company: {$company->name}");
            $this->command->info("  - Contact: {$contact->name}");
            $this->command->info("  - Amount: $" . number_format($amount, 2));
            $this->command->info("  - Stage: {$dealStage}");
            $this->command->info("  - Priority: {$priority}");
            $this->command->info("  - Type: {$dealType}");
            $this->command->info("  - Service: {$service}");

            try {
                $deal = Deal::create([
                    'cus_company_key' => $company->special_key,
                    'cus_contact_key' => $contact->special_key,
                    'name' => $dealName,
                    'deal_stage' => $dealStage,
                    'amount' => $amount,
                    'start_date' => $startDate,
                    'close_date' => $closeDate,
                    'deal_type' => $dealType,
                    'priority' => $priority,
                    'services' => $service,
                    'is_contact_start_date' => rand(0, 1),
                    'contact_start_date' => rand(0, 1) ? now()->addDays(rand(1, 30)) : null,
                    'is_company_start_date' => rand(0, 1),
                    'company_start_date' => rand(0, 1) ? now()->addDays(rand(1, 30)) : null,
                    'creator_type' => 'App\Models\User',
                    'creator_id' => $user->id,
                    'status' => rand(0, 1),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $this->command->info("✓ Deal {$i} created successfully (ID: {$deal->id})");
                
            } catch (\Exception $e) {
                $this->command->error("✗ Failed to create deal {$i}: " . $e->getMessage());
                continue;
            }

            // Small delay to see the progress better
            if ($i < 20) {
                usleep(100000); // 0.1 second delay
            }
        }

        $totalDeals = Deal::count();
        $this->command->info("\n=========================================");
        $this->command->info("🎉 Seeding completed successfully!");
        $this->command->info("📊 Total deals created: {$totalDeals}/20");
        $this->command->info("=========================================");
    }
    /**
     * Generate realistic deal names
     */
    private function generateDealName($index, $companyName, $dealType): string
    {
        $products = [
            'Software License',
            'Consulting Services',
            'Marketing Campaign',
            'Web Development',
            'Mobile App',
            'Cloud Services',
            'Training Program',
            'Support Contract',
            'Hardware Purchase',
            'Integration Project'
        ];

        $product = $products[array_rand($products)];

        return "{$companyName} - {$product} {$dealType}";
    }
}

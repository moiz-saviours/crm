<?php

namespace Database\Seeders;

use App\Models\LeadStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $statuses = [
            ['name' => 'New', 'color' => '#3498db', 'description' => 'Newly created lead.'],
            ['name' => 'Contacted', 'color' => '#1abc9c', 'description' => 'Lead has been contacted.'],
            ['name' => 'Qualified', 'color' => '#2ecc71', 'description' => 'Lead has been qualified.'],
            ['name' => 'Proposal Sent', 'color' => '#f1c40f', 'description' => 'Proposal sent to the lead.'],
            ['name' => 'Negotiation', 'color' => '#e67e22', 'description' => 'In negotiation with the lead.'],
            ['name' => 'Closed - Won', 'color' => '#27ae60', 'description' => 'Lead has been closed successfully.'],
            ['name' => 'Closed - Lost', 'color' => '#e74c3c', 'description' => 'Lead has been lost.'],
            ['name' => 'Follow-Up', 'color' => '#9b59b6', 'description' => 'Follow-up is needed with the lead.'],
            ['name' => 'Demo Scheduled', 'color' => '#34495e', 'description' => 'Demo has been scheduled for the lead.'],
            ['name' => 'Awaiting Response', 'color' => '#7f8c8d', 'description' => 'Waiting for a response from the lead.'],
            ['name' => 'Disqualified', 'color' => '#95a5a6', 'description' => 'Lead has been disqualified.'],
            ['name' => 'Needs Analysis', 'color' => '#d35400', 'description' => 'Analyzing lead requirements.'],
            ['name' => 'Pending Approval', 'color' => '#8e44ad', 'description' => 'Lead approval is pending.'],
            ['name' => 'On Hold', 'color' => '#2c3e50', 'description' => 'Lead is on hold for now.'],
            ['name' => 'Rejected', 'color' => '#c0392b', 'description' => 'Lead has been rejected.'],
            ['name' => 'Test', 'color' => '#000000', 'description' => 'Testing lead.'],
        ];

        foreach ($statuses as $status) {
            LeadStatus::create($status);
        }
    }
}

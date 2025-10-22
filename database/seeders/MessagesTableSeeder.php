<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\Admin;
use App\Models\CustomerContact;
use App\Models\Project;
use App\Models\Task;
use App\Models\Invoice;
use Illuminate\Support\Str;

class MessagesTableSeeder extends Seeder
{
    public function run(): void
    {
        $admins = Admin::pluck('id')->toArray();
        $customerContacts = CustomerContact::pluck('id')->toArray();

        if (empty($admins)) {
            $this->command->warn('⚠️ No admins found. Please seed Admins first.');
            return;
        }

        if (empty($customerContacts)) {
            $this->command->warn('⚠️ No customer contacts found. Please seed CustomerContacts first.');
            return;
        }

        // Context models - these will be the conversation contexts
        $contexts = [
            ['type' => Project::class, 'ids' => Project::pluck('id')->toArray(), 'name' => 'Project'],
            ['type' => Task::class, 'ids' => Task::pluck('id')->toArray(), 'name' => 'Task'],
            ['type' => Invoice::class, 'ids' => Invoice::pluck('id')->toArray(), 'name' => 'Invoice'],
            ['type' => CustomerContact::class, 'ids' => $customerContacts, 'name' => 'General'], // General conversations
        ];

        $conversations = [];
        $messages = [];

        foreach ($contexts as $context) {
            if (empty($context['ids'])) continue;

            // Create 3-5 conversations for each context type
            $conversationCount = rand(3, 5);
            
            for ($i = 0; $i < $conversationCount; $i++) {
                $adminId = $admins[array_rand($admins)];
                $customerContactId = $customerContacts[array_rand($customerContacts)];
                $contextId = $context['ids'][array_rand($context['ids'])];
                
                $conversation = Conversation::create([
                    'sender_type' => Admin::class,
                    'sender_id' => $adminId,
                    'receiver_type' => CustomerContact::class,
                    'receiver_id' => $customerContactId,
                    'conversation_status' => 'approved',
                    'context_type' => $context['type'],
                    'context_id' => $contextId,
                    'status' => 1,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now()->subDays(rand(0, 29)),
                ]);

                $conversations[] = $conversation;

                // Create 2-6 messages for each conversation
                $messageCount = rand(2, 6);
                $lastMessage = null;

                for ($j = 0; $j < $messageCount; $j++) {
                    $isFromAdmin = (bool)rand(0, 1);
                    $messageType = 'text'; // Simplified for context chats
                    
                    $messageData = [
                        'conversation_id' => $conversation->id,
                        'sender_type' => $isFromAdmin ? Admin::class : CustomerContact::class,
                        'sender_id' => $isFromAdmin ? $adminId : $customerContactId,
                        'content' => $this->generateContextMessage($context['name'], $contextId, $isFromAdmin),
                        'message_type' => $messageType,
                        'message_status' => 'delivered',
                        'status' => 1,
                        'created_at' => $conversation->created_at->addMinutes($j * 15),
                        'updated_at' => $conversation->created_at->addMinutes($j * 15),
                    ];

                    $message = Message::create($messageData);
                    $lastMessage = $message;
                    $messages[] = $message;
                }

                // Update conversation with last message
                if ($lastMessage) {
                    $conversation->update([
                        'last_message_id' => $lastMessage->id,
                        'updated_at' => $lastMessage->created_at,
                    ]);
                }
            }
        }

        $this->command->info('✅ Created ' . count($conversations) . ' context-based conversations with ' . count($messages) . ' messages');
    }

    private function generateContextMessage(string $contextType, int $contextId, bool $isFromAdmin): string
    {
        $contextMessages = [
            'Project' => [
                'admin' => [
                    "I've updated the project timeline for #{$contextId}",
                    "The project #{$contextId} deliverables are on track",
                    "Can we schedule a review meeting for project #{$contextId}?",
                    "I've attached the latest project documentation for #{$contextId}"
                ],
                'customer' => [
                    "Thanks for the update on project #{$contextId}",
                    "I have some questions about project #{$contextId} timeline",
                    "The project #{$contextId} is looking great so far",
                    "When is the next milestone for project #{$contextId}?"
                ]
            ],
            'Task' => [
                'admin' => [
                    "Task #{$contextId} has been completed",
                    "I need more information to proceed with task #{$contextId}",
                    "Task #{$contextId} is scheduled for next week",
                    "The resources for task #{$contextId} have been allocated"
                ],
                'customer' => [
                    "Can you provide an update on task #{$contextId}?",
                    "Task #{$contextId} requirements have changed slightly",
                    "Thanks for completing task #{$contextId}",
                    "I have feedback on task #{$contextId}"
                ]
            ],
            'Invoice' => [
                'admin' => [
                    "Invoice #{$contextId} has been sent for payment",
                    "Payment received for invoice #{$contextId}",
                    "Following up on invoice #{$contextId} payment",
                    "I've updated the details for invoice #{$contextId}"
                ],
                'customer' => [
                    "I have a question about invoice #{$contextId}",
                    "Payment for invoice #{$contextId} has been processed",
                    "Can you resend invoice #{$contextId}?",
                    "I noticed an issue with invoice #{$contextId}"
                ]
            ],
            'General' => [
                'admin' => [
                    "Hello, how can I help you today?",
                    "Thanks for reaching out to us",
                    "I'm here to assist with any questions",
                    "Let me know if you need anything else"
                ],
                'customer' => [
                    "Hello, I need some assistance",
                    "Thanks for your help",
                    "Can you help me with something?",
                    "I have a general question"
                ]
            ]
        ];

        $role = $isFromAdmin ? 'admin' : 'customer';
        $messages = $contextMessages[$contextType][$role] ?? $contextMessages['General'][$role];
        
        return $messages[array_rand($messages)];
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Message;
use App\Models\Conversation;
use App\Models\Admin;
use Illuminate\Support\Str;

class MessagesTableSeeder extends Seeder
{
    public function run(): void
    {
        $admins = Admin::pluck('id')->toArray();

        // Ensure there are admins
        if (empty($admins)) {
            $this->command->warn('⚠️ No admins found. Please seed Admins first.');
            return;
        }

        // Initialize admin-to-admin conversations if none exist
        if (Conversation::count() === 0) {
            foreach ($admins as $senderId) {
                foreach ($admins as $receiverId) {
                    if ($senderId === $receiverId) {
                        continue; // skip self-conversation
                    }

                    Conversation::create([
                        'senderable_id' => $senderId,
                        'senderable_type' => Admin::class,
                        'receiverable_id' => $receiverId,
                        'receiverable_type' => Admin::class,
                        'conversation_status' => 'approved',
                        'status' => true,
                    ]);
                }
            }
        }

        $conversations = Conversation::all();

        foreach ($conversations as $conversation) {
            // Create 3–8 messages per conversation
            for ($i = 0; $i < rand(3, 8); $i++) {
                $senderId = $admins[array_rand($admins)];

                $message = Message::create([
                    'conversation_id' => $conversation->id,
                    'senderable_id' => $senderId,
                    'senderable_type' => Admin::class,
                    'content' => 'Admin message: ' . Str::random(20),
                    'message_type' => ['text', 'image', 'video', 'audio', 'file', 'system'][array_rand(['text', 'image', 'video', 'audio', 'file', 'system'])],
                    'message_status' => ['sent', 'delivered', 'seen', 'failed'][array_rand(['sent', 'delivered', 'seen', 'failed'])],
                    'status' => true,
                    'edited_at' => null,
                ]);

                // Optionally set as reply to a previous message
                if ($i > 0 && rand(0, 1)) {
                    $replyTo = $conversation->messages()->inRandomOrder()->first();
                    if ($replyTo) {
                        $message->reply_to = $replyTo->id;
                        $message->save();
                    }
                }

                // Randomly soft-delete a few
                if (rand(0, 15) === 5) {
                    $message->delete();
                }
            }

            // Update last message reference
            $conversation->last_message_id = $conversation->messages()->latest()->first()->id ?? null;
            $conversation->save();
        }

        $this->command->info('✅ Admin-only conversations and messages seeded successfully.');
    }
}

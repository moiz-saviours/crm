<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Email;
use App\Models\UserPseudoRecord;
use App\Http\Controllers\Admin\EmailController as AdminEmailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RetryFailedEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:retry 
                            {--all : Retry all failed emails}
                            {--account= : Retry failed emails for a specific account (email address)}
                            {--limit=50 : Limit the number of emails to retry}
                            {--dry-run : Show what would be retried without actually sending}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retry failed email sends for all or specific accounts';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $emailController = new AdminEmailController();
        $options = $this->options();

        // Validate options
        if (!$options['all'] && !$options['account']) {
            $this->error('You must specify either --all or --account option');
            return 1;
        }

        if ($options['all'] && $options['account']) {
            $this->error('You cannot use both --all and --account options together');
            return 1;
        }

        // Build query for failed emails
        $query = Email::where('send_status', 'failed')
            ->whereNull('sent_at')
            ->orderBy('last_attempt_at', 'asc')
            ->limit($options['limit']);

        // Filter by account if specified
        if ($options['account']) {
            $query->where('from_email', $options['account']);
            
            // Verify account exists
            $accountExists = UserPseudoRecord::where('pseudo_email', $options['account'])->exists();
            if (!$accountExists) {
                $this->error("Account {$options['account']} not found");
                return 1;
            }
        }

        $emails = $query->get();

        if ($emails->isEmpty()) {
            $this->info('No failed emails found to retry.');
            return 0;
        }

        $this->info("Found {$emails->count()} failed emails to retry.");

        if ($options['dry-run']) {
            $this->info("DRY RUN - No emails will be actually sent.");
            $this->newLine();
            
            $this->table(
                ['ID', 'From', 'To', 'Subject', 'Last Attempt', 'Error'],
                $emails->map(function ($email) {
                    return [
                        $email->id,
                        $email->from_email,
                        collect($email->to)->pluck('email')->implode(', '),
                        $email->subject,
                        $email->last_attempt_at?->format('Y-m-d H:i:s') ?? 'Never',
                        substr($email->error_message ?? 'Unknown error', 0, 50) . '...'
                    ];
                })
            );
            return 0;
        }

        $successCount = 0;
        $failCount = 0;

        $progressBar = $this->output->createProgressBar($emails->count());
        $progressBar->start();

        foreach ($emails as $email) {
            try {
                // Use your existing retryEmail method
                $response = $emailController->retryEmail($email->id);
                $result = json_decode($response->getContent(), true);

                if ($result['success']) {
                    $successCount++;
                    Log::info('Email retry successful via command', [
                        'email_id' => $email->id,
                        'from' => $email->from_email,
                        'subject' => $email->subject
                    ]);
                } else {
                    $failCount++;
                    Log::error('Email retry failed via command', [
                        'email_id' => $email->id,
                        'from' => $email->from_email,
                        'subject' => $email->subject,
                        'error' => $result['message'] ?? 'Unknown error'
                    ]);
                }
            } catch (\Exception $e) {
                $failCount++;
                Log::error('Exception during email retry via command', [
                    'email_id' => $email->id,
                    'from' => $email->from_email,
                    'subject' => $email->subject,
                    'error' => $e->getMessage()
                ]);
            }

            $progressBar->advance();
            
            // Small delay to avoid overwhelming the SMTP server
            usleep(100000); // 0.1 second
        }

        $progressBar->finish();
        $this->newLine(2);

        $this->info("Retry process completed:");
        $this->info("✅ Successful: {$successCount}");
        $this->info("❌ Failed: {$failCount}");

        return $failCount > 0 ? 1 : 0;
    }
}
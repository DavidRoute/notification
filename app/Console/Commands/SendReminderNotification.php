<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Policy;
use App\Jobs\PolicyNotificationJob;

class SendReminderNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:reminder-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending reminder notification to users.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Policy::nextMonthDue()->cursor()->each(function ($policy) 
        {
            PolicyNotificationJob::dispatch($policy, [
                'title' => 'Policy Reminder',
                'body'  => 'Policy reminder description.'
            ]);
        });

        $this->line('Complete');
    }
}

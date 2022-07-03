<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;
use ExpoSDK\Expo;
use ExpoSDK\ExpoMessage;

class PolicyNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $policy, $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($policy, array $payload)
    {
        $this->policy = $policy;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $messageArr = $this->payload;

        Notification::create($messageArr);

        $message = (new ExpoMessage($messageArr));

        $user = $this->policy->user;
        $recipients = [$user->device_token];

        $response = (new Expo)->send($message)->to($recipients)->push();

        \Log::info('Policy Notification: ', $response->getData());
    }
}

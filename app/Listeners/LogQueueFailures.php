<?php

namespace App\Listeners;

use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\QueueJobFailedNotification;

class LogQueueFailures
{
    public function handle(JobFailed $event)
    {
        $jobName = $event->job->resolveName();
        $error = $event->exception->getMessage();

        // Log to storage/logs/laravel.log
        Log::error('Queued job failed', [
            'job' => $jobName,
            'connection' => $event->connectionName,
            'queue' => $event->job->getQueue(),
            'error' => $error,
        ]);

        // Send notification to admin(s)
        $admins = config('queue.admins');
        if ($admins) {
            Notification::route('mail', $admins)
                //->route('slack', config('services.slack.webhook_url'))
                ->notify(new QueueJobFailedNotification($jobName, $error));
        }
    }
}

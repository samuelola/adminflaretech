<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class QueueJobFailedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $jobName;
    protected $exception;

    public function __construct($jobName, $exception)
    {
        $this->jobName = $jobName;
        $this->exception = $exception;
    }

    public function via($notifiable)
    {
        // You can send both email and Slack notifications if desired
        return ['mail', 'slack'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Queued Job Failed: ' . $this->jobName)
            ->line('A queued job has failed.')
            ->line('**Job:** ' . $this->jobName)
            ->line('**Error:** ' . $this->exception)
            ->line('Please check the Laravel logs or queue dashboard for more info.');
    }

    public function toSlack($notifiable)
    {
        return (new SlackMessage)
            ->error()
            ->content("*Queued Job Failed!*")
            ->attachment(function ($attachment) {
                $attachment->fields([
                    'Job' => $this->jobName,
                    'Error' => $this->exception,
                    'Time' => now()->toDateTimeString(),
                ]);
            });
    }
}

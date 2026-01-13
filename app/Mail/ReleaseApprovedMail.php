<?php

namespace App\Mail;

use App\Models\MusicRelease;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReleaseApprovedMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $release;
    public $jsonUrl;
    public $xmlUrl;
    public $csvUrl;

    public function __construct(MusicRelease $release, $jsonUrl, $xmlUrl, $csvUrl)
    {
        $this->release = $release;
        $this->jsonUrl = $jsonUrl;
        $this->xmlUrl = $xmlUrl;
        $this->csvUrl = $csvUrl;
    }

    public function build()
    {
        return $this->subject('Release Approved – Metadata Files Ready')
                    ->markdown('emails.releases.approved')
                    ->withSwiftMessage(function ($message) {
                    \Log::info('Queued release approval email', [
                        'release_id' => $this->release->id,
                        'to' => $message->getTo(),
                    ]);
                });
    }
}

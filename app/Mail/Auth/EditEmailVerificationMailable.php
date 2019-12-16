<?php

declare(strict_types=1);

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EditEmailVerificationMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $verifyUrl;

    public $userName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $verifyUrl, string $userName)
    {
        $this->verifyUrl = $verifyUrl;
        $this->userName = $userName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.auth.editverify')
            ->subject('【重要】メール認証のお願い');
    }
}

<?php

declare(strict_types=1);

namespace App\Mail\Auth;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailVerificationMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    public $verifyUrl;

    public $userName;

    public $is_edit;

    /**
     * Create a new message instance.
     *
     * @param  string  $verifyUrl  メール認証を完了させるための URL
     * @param  string  $userName  宛先ユーザーのフルネーム
     * @return void
     */
    public function __construct(string $verifyUrl, string $userName, bool $is_edit)
    {
        $this->verifyUrl = $verifyUrl;
        $this->userName = $userName;
        $this->is_edit = $is_edit;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.auth.verify')
            ->subject('【重要】メール認証のお願い');
    }
}

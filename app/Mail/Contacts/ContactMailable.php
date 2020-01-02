<?php

namespace App\Mail\Contacts;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Eloquents\Circle;
use App\Eloquents\User;

class ContactMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(?Circle $circle, User $user, string $body)
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('view.name')
            ->subject('お問い合わせを承りました');
    }
}

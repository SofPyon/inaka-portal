<?php

declare(strict_types=1);

namespace App\Services\Auth;

use Illuminate\Support\Facades\Mail;
use App\Eloquents\Circle;
use App\Eloquents\User;

class ContactsService
{
    /**
     * お問い合わせを作成する
     *
     * @param Circle|null $circle お問い合わせ対象の団体
     * @param User $user お問い合わせを作成したユーザー
     * @param string $body お問い合わせ本文
     * @return bool
     */
    public function create(?Circle $circle, User $user, string $body)
    {
    }

    private function send()
    {
        Mail::to($recipient)
            ->send(new EmailVerificationMailable($verifyUrl, $name));
    }
}

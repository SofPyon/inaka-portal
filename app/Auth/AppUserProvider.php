<?php

declare(strict_types=1);

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class AppUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        if (!$credentials['login_id']) {
            return null;
        }

        /** @var Authenticatable $user */
        $user = $this->createModel()->newQuery()
            ->where('email', $credentials['loginId'])
            ->orWhere('student_id')
            ->first();

        return $user;
    }
}

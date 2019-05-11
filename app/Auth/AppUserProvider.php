<?php

declare(strict_types=1);

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;

class AppUserProvider extends EloquentUserProvider
{
    public function retrieveByCredentials(array $credentials): ?Authenticatable
    {
        if (empty($credentials['login_id'])) {
            return null;
        }

        /** @var Authenticatable $user */
        $user = $this->createModel()->newQuery()
            ->where('email', $credentials['login_id'])
            ->orWhere('student_id', $credentials['login_id'])
            ->first();

        return $user;
    }
}

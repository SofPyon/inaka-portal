<?php

namespace App\Http\Middleware;

use App\Eloquents\User;
use Closure;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var User $user */
        $user = $request->user();

        if (! $user || ! $user->hasVerifiedEmail() || ! $user->hasVerifiedUnivemail()) {
            return redirect()->route('verification.notice');
        }

        return $next($request);
    }
}

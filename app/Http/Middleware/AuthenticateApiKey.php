<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        $expectedKey = config('services.internal_api.key');
        $userEmail = config('services.internal_api.user_email');

        if (! is_string($expectedKey) || $expectedKey === '' || ! is_string($userEmail) || $userEmail === '') {
            return response()->json([
                'message' => 'API key authentication is not configured.',
            ], 503);
        }

        $providedKey = $request->header('X-API-KEY', '');

        if (! is_string($providedKey) || ! hash_equals($expectedKey, $providedKey)) {
            return response()->json([
                'message' => 'A valid X-API-KEY header is required.',
            ], 401);
        }

        $user = User::query()->where('email', $userEmail)->first();

        if (! $user) {
            return response()->json([
                'message' => 'The API key is not associated with an available account.',
            ], 503);
        }

        $request->setUserResolver(fn (?string $guard = null): User => $user);

        return $next($request);
    }
}

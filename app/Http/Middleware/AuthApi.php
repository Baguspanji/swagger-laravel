<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthApi
{
    public function handle(Request $request, Closure $next, string $auth = 'global')
    {
        // status
        if (Auth::user()->status == false) {
            return $this->unauthorized();
        }

        $groupRoles = [
            'global' => [
                'admin',
                'teknisi',
                'sales'
            ],
            'admin' => [
                'admin'
            ],
            'sales' => [
                'sales'
            ],
            'teknisi' => [
                'teknisi'
            ],
        ];

        $user_roles = Auth::user()->roles;
        $roles = $groupRoles[$auth];

        $isValidate = false;
        foreach ($user_roles as $user_role) {
            if (in_array($user_role, $roles)) {
                $isValidate = true;
                break;
            }
        }

        if (!$isValidate) {
            return $this->unauthorized();
        }

        return $next($request);
    }

    private function unauthorized($message = null)
    {
        return response()->json([
            'message' => $message ? $message : 'You are unauthorized to access this resource',
            'success' => false,
        ], 401);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , string $permission): Response
    {
        $user = $request->user();
    if (!$user) {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    // دعم لكتابة أكثر من صلاحية مفصولة بفاصلة: permission:edit,delete
    $permissions = array_map('trim', explode(',', $permission));

    foreach ($permissions as $perm) {
        if ($user->hasPermission($perm)) {
            return $next($request);
        }
    }
    return response()->json(['message' => 'Forbidden'], 403);
}
}
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
 /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // تحقق مما إذا كان المستخدم مسجلاً الدخول و هو مدير
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }

        // إعادة توجيه أو رد بخطأ في حال لم يكن المدير
        return response()->json(['message' => 'غير مصرح لك بالوصول إلى هذه الصفحة.'], 403);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Check approval status
            if ($user->approval_status === 'pending') {
                Auth::logout();
                return redirect()->route('login')
                    ->withErrors(['email' => 'Akun Anda sedang menunggu persetujuan admin. Silakan coba lagi nanti.']);
            }

            if ($user->approval_status === 'rejected') {
                Auth::logout();
                $message = 'Akun Anda ditolak oleh admin.';
                if ($user->rejection_reason) {
                    $message .= ' Alasan: ' . $user->rejection_reason;
                }
                return redirect()->route('login')
                    ->withErrors(['email' => $message]);
            }
        }

        return $next($request);
    }
}

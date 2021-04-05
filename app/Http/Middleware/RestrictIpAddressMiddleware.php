<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class RestrictIpAddressMiddleware
{
    // Blocked IP addresses
    public $whiteListIp = [
        // '127.0.0.1',
        '192.168.0.1', '10.1.8.2', '82.208.170.3'];

    // Blocked IP addresses
    // public $restrictedIp = ['192.168.0.1', '202.173.125.72', '192.168.0.3', '202.173.125.71'];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) // I included this check because you have it, but it really should be part of your 'auth' middleware, most likely added as part of a route group.
            return redirect('login');

        $user = Auth::user();

        // if($user->role === 'service_voluntar') {
        //     if (!in_array($request->ip(), $this->whiteListIp)) {
        //         return redirect('/')->with('error', 'Nu ai acces la această resursă de pe acest IP');
        //     }
        // }

        return $next($request);
    }
}

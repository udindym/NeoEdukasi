<?php
  
namespace App\Http\Middleware;
  
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
  
class IsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ((Auth::user()->account_status) < 0 ) {
            
            return redirect()->route('tentor.dashboard')
                    ->with('errormsg', 'Anda harus mengaktifkan akun Anda terlebih dahulu. Harap verifikasi akun anda.');
        }

        return $next($request);
    }
}
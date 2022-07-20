<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ExceptAdmin
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
        if (Auth::user()->role == 'user') {
            $request->session()->flash('alert', 'danger');
            $request->session()->flash('message', 'Kamu tidak punya akses untuk halaman ini!');
            return redirect()->to(route('home'));
        }
        return $next($request);
    }
}

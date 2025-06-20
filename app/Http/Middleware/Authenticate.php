<?php

namespace App\Http\Middleware;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Arr;
class Authenticate extends Middleware
{
     protected $guards = [];

    public function handle($request, \Closure $next, ...$guards)
    {
        $this->guards = $guards;
        return parent::handle($request, $next, ...$guards);
    }

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            $guard = Arr::first($this->guards);
            switch ($guard) {
                case 'admin':
                    return route('admin.login');
                default:
                    return route('login');
            }
        }
    }
}

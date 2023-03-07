<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

// ★app\Providers\RouteServiceProviderで設定した個所を変数に代入★
class Authenticate extends Middleware
{
    protected $user_route = 'user.login';
    protected $owner_route = 'owner.login';
    protected $admin_route = 'admin.login';

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

    // ★認証をGuardごとにリダイレクト先を変更している★
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if(Route::is('owner.*')){
                return route($this->owner_route);
            } elseif(Route::is('admin.*')){
                return route($this->admin_route);
            } else {
                return route($this->user_route);
            }
        }
    }
}
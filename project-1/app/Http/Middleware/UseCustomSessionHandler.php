<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class UseCustomSessionHandler
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('custom')->check()) {
            Session::resolved(function ($session) {
                $session->extend('custom', function ($app) {
                    $table = $app['config']['session.table'];
                    $lifetime = $app['config']['session.lifetime'];
                    $connection = $app['db']->connection($app['config']['session.connection']);
                    return new \App\Custom\CustomDataBaseSessionHandler($connection, $table, $lifetime, $app);
                });
            });
        }

        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\SettingsHelper;

class MaintenanceModeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip maintenance mode for admin routes and API routes
        if ($request->is('admin/*') || $request->is('api/*')) {
            return $next($request);
        }

        // Skip for authenticated admin users
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Check if maintenance mode is enabled
        if (SettingsHelper::isMaintenanceMode()) {
            $message = SettingsHelper::get('maintenance_message', 'Site is under maintenance. Please check back later.');
            
            return response()->view('maintenance', [
                'message' => $message,
                'siteName' => SettingsHelper::get('site_name', 'Website'),
                'logo' => SettingsHelper::getLogo()
            ], 503);
        }

        return $next($request);
    }
}

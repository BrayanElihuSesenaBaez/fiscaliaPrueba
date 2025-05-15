<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;  // Importar el Request correcto
use Illuminate\Support\Facades\View;
use App\Models\Settings;

class LoadSettings
{
    public function handle(Request $request, Closure $next)
    {
        // Cargar los ajustes desde la base de datos
        $settings = Settings::first();

        // Compartir los ajustes con todas las vistas
        view()->share('settings', $settings);

        return $next($request);
    }
}

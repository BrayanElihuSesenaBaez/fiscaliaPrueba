<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;


class SettingsController extends Controller
{
    public function showForm(): \Illuminate\Contracts\View\View
    {
        $settings = Settings::first(); // Obtiene el primer registro
        return view('color', compact('settings')); // Pasa los datos a la vista
    }

    public function update(Request $request): \Illuminate\Http\RedirectResponse
    {

        $request->validate([
            'background_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'text_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'button_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'btn_primary' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'login_button_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
            'login_text_color' => 'required|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);


        // Guardar los valores en la base de datos
        Settings::updateOrCreate(
            ['id' => 1], // Condición de búsqueda
            [
                'background_color' => $request->input('background_color'),
                'text_color' => $request->input('text_color'),
                'button_color' => $request->input('button_color'),
                'btn_primary' => $request->input('btn_primary'),
                'login_button_color' => $request->input('login_button_color'),
                'login_text_color' => $request->input('login_text_color'),
            ]
        );
        return redirect()->route('settings.form')->with('success', 'Colores actualizados correctamente');
    }
}

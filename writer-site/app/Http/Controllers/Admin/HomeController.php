<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::first();

        return view('admin.home.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = SiteSetting::firstOrFail();

        $data = $request->validate([
            'hero_text' => ['required', 'string', 'max:500'],
            'hero_image' => ['nullable', 'image', 'max:4096'],
        ], [
            'hero_text.required' => 'Este texto se muestra en la parte principal de la página de inicio.',
            'hero_text.max' => 'Por claridad visual, el texto principal no debe ser demasiado largo.',
            'hero_image.image' => 'La imagen debe ser un archivo de tipo imagen (JPG, PNG, etc.).',
        ]);

        if ($request->hasFile('hero_image')) {
            $path = $request->file('hero_image')->store('hero', 'public');
            $data['hero_image'] = $path;
            // Asegurar permisos del archivo subido
            $fullPath = storage_path('app/public/' . $path);
            if (file_exists($fullPath)) {
                @chmod($fullPath, 0644);
            }
        }

        $settings->update($data);

        return redirect()
            ->route('admin.home.edit')
            ->with('status', 'La portada se ha actualizado correctamente.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::first();

        return view('admin.settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = SiteSetting::firstOrFail();

        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url' => ['nullable', 'url', 'max:255'],
        ], [
            'site_name.required' => 'Este nombre aparecerá en la parte superior del sitio.',
            'contact_email.email' => 'Introduce un correo electrónico válido para recibir mensajes.',
            'instagram_url.url' => 'La URL de Instagram debe ser válida.',
            'facebook_url.url' => 'La URL de Facebook debe ser válida.',
            'tiktok_url.url' => 'La URL de TikTok debe ser válida.',
        ]);

        $settings->update($data);

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Los datos generales del sitio se han actualizado.');
    }
}

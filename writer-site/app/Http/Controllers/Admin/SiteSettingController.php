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
        app()->setLocale('es');
        $settings = SiteSetting::firstOrFail();

        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'tiktok_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'pinterest_url' => ['nullable', 'url', 'max:255'],
            'privacy_policy' => ['nullable', 'string'],
            'terms_of_service' => ['nullable', 'string'],
            'legal_notice' => ['nullable', 'string'],
            'cookie_policy' => ['nullable', 'string'],
            'cookies_enabled' => ['nullable', 'boolean'],
        ], [
            'site_name.required' => 'Este nombre aparecerá en la parte superior del sitio.',
            'site_name.max' => 'El nombre del sitio no puede tener más de 255 caracteres.',
            'tagline.max' => 'El eslogan no puede tener más de 255 caracteres.',
            'contact_email.email' => 'Introduce un correo electrónico válido para recibir mensajes.',
            'instagram_url.url' => 'La URL de Instagram debe ser válida (ejemplo: https://instagram.com/usuario).',
            'instagram_url.max' => 'La URL de Instagram no puede tener más de 255 caracteres.',
            'facebook_url.url' => 'La URL de Facebook debe ser válida (ejemplo: https://facebook.com/usuario).',
            'facebook_url.max' => 'La URL de Facebook no puede tener más de 255 caracteres.',
            'tiktok_url.url' => 'La URL de TikTok debe ser válida (ejemplo: https://tiktok.com/@usuario).',
            'tiktok_url.max' => 'La URL de TikTok no puede tener más de 255 caracteres.',
            'twitter_url.url' => 'La URL de Twitter/X debe ser válida (ejemplo: https://twitter.com/usuario).',
            'twitter_url.max' => 'La URL de Twitter/X no puede tener más de 255 caracteres.',
            'youtube_url.url' => 'La URL de YouTube debe ser válida (ejemplo: https://youtube.com/@usuario).',
            'youtube_url.max' => 'La URL de YouTube no puede tener más de 255 caracteres.',
            'linkedin_url.url' => 'La URL de LinkedIn debe ser válida (ejemplo: https://linkedin.com/in/usuario).',
            'linkedin_url.max' => 'La URL de LinkedIn no puede tener más de 255 caracteres.',
            'pinterest_url.url' => 'La URL de Pinterest debe ser válida (ejemplo: https://pinterest.com/usuario).',
            'pinterest_url.max' => 'La URL de Pinterest no puede tener más de 255 caracteres.',
        ]);

        $settings->update($data);

        return redirect()
            ->route('admin.settings.edit')
            ->with('status', 'Los datos generales del sitio se han actualizado.');
    }
}

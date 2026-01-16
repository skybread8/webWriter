<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LegalController extends Controller
{
    public function edit(): View
    {
        $settings = SiteSetting::first();

        return view('admin.legal.edit', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        app()->setLocale('es');
        $settings = SiteSetting::firstOrFail();

        $data = $request->validate([
            'privacy_policy' => ['nullable', 'string'],
            'terms_of_service' => ['nullable', 'string'],
            'legal_notice' => ['nullable', 'string'],
            'cookie_policy' => ['nullable', 'string'],
            'cookies_enabled' => ['nullable', 'boolean'],
        ]);

        $settings->update($data);

        return redirect()
            ->route('admin.legal.edit')
            ->with('status', 'Las políticas legales se han actualizado correctamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\View\View;

class LegalController extends Controller
{
    public function privacy(): View
    {
        $settings = SiteSetting::first();
        
        return view('site.legal.privacy', [
            'content' => $settings?->privacy_policy ?? '',
            'settings' => $settings,
        ]);
    }

    public function terms(): View
    {
        $settings = SiteSetting::first();
        
        return view('site.legal.terms', [
            'content' => $settings?->terms_of_service ?? '',
            'settings' => $settings,
        ]);
    }

    public function legalNotice(): View
    {
        $settings = SiteSetting::first();
        
        return view('site.legal.notice', [
            'content' => $settings?->legal_notice ?? '',
            'settings' => $settings,
        ]);
    }

    public function cookies(): View
    {
        $settings = SiteSetting::first();
        
        return view('site.legal.cookies', [
            'content' => $settings?->cookie_policy ?? '',
            'settings' => $settings,
        ]);
    }
}

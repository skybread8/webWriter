<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Tarjetas simples para que el admin vea de un vistazo el estado del sitio.
        return view('admin.dashboard', [
            'booksCount' => Book::count(),
            'activeBooksCount' => Book::where('active', true)->count(),
            'aboutPage' => Page::where('slug', 'about')->first(),
            'contactPage' => Page::where('slug', 'contact')->first(),
            'settings' => SiteSetting::first(),
        ]);
    }
}

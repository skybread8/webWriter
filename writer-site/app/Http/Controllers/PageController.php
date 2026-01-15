<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\Book;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function home()
    {
        $settings = SiteSetting::first();
        $books = Book::where('active', true)->orderBy('created_at', 'desc')->get();

        return view('site.home', compact('settings', 'books'));
    }

    public function about()
    {
        $page = Page::where('slug', 'about')->first();

        return view('site.about', compact('page'));
    }

    public function contact()
    {
        $page = Page::where('slug', 'contact')->first();
        $settings = SiteSetting::first();

        return view('site.contact', compact('page', 'settings'));
    }

    public function sendContact(Request $request)
    {
        $settings = SiteSetting::first();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'name.required' => 'Escribe tu nombre.',
            'email.required' => 'Indica un correo para poder responderte.',
            'email.email' => 'El formato del correo no parece válido.',
            'message.required' => 'Escribe un mensaje antes de enviar.',
        ]);

        $toEmail = $settings?->contact_email;

        if ($toEmail) {
            Mail::to($toEmail)->send(new ContactMessageMail(
                $data['name'],
                $data['email'],
                $data['message']
            ));
        }

        return redirect()
            ->route('contact')
            ->with('status', 'Mensaje enviado. Te responderemos en cuanto sea posible.');
    }

    public function faq()
    {
        $page = Page::where('slug', 'faq')->first();

        return view('site.page', compact('page'));
    }

    public function blog()
    {
        $page = Page::where('slug', 'blog')->first();

        return view('site.page', compact('page'));
    }

    public function photosReaders()
    {
        $page = Page::where('slug', 'photos-readers')->first();

        return view('site.page', compact('page'));
    }

    public function photosBooks()
    {
        $page = Page::where('slug', 'photos-books')->first();

        return view('site.page', compact('page'));
    }

    public function offers()
    {
        $page = Page::where('slug', 'offers')->first();

        return view('site.page', compact('page'));
    }
}

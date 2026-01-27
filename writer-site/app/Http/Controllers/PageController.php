<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use App\Models\Book;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

if (!function_exists('localized_route')) {
    require_once app_path('Helpers/UrlHelper.php');
}

class PageController extends Controller
{
    public function home()
    {
        $settings = SiteSetting::first();
        $books = Book::where('active', true)
            ->withReviewStats()
            ->with(['images' => function($query) {
                $query->orderBy('order')->orderBy('created_at');
            }])
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

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
        app()->setLocale('es');
        $settings = SiteSetting::first();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'message' => ['required', 'string', 'max:2000'],
        ], [
            'name.required' => 'Escribe tu nombre.',
            'name.max' => 'El nombre no puede tener más de 255 caracteres.',
            'email.required' => 'Indica un correo para poder responderte.',
            'email.email' => 'El formato del correo no parece válido.',
            'message.required' => 'Escribe un mensaje antes de enviar.',
            'message.max' => 'El mensaje no puede tener más de 2000 caracteres.',
        ]);

        // Guardar mensaje en la base de datos
        \App\Models\ContactMessage::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message'],
        ]);

        $toEmail = $settings?->contact_email;

        if ($toEmail) {
            try {
                Mail::to($toEmail)->send(new ContactMessageMail(
                    $data['name'],
                    $data['email'],
                    $data['message']
                ));
                
                // Registrar email enviado
                if (function_exists('track_sent_email')) {
                    track_sent_email('contact', $toEmail, 'Nuevo mensaje desde la web', "De: {$data['name']} ({$data['email']})\n\n{$data['message']}", true);
                }
            } catch (\Exception $e) {
                // Registrar error
                if (function_exists('track_sent_email')) {
                    track_sent_email('contact', $toEmail, 'Nuevo mensaje desde la web', null, false, $e->getMessage());
                }
                throw $e;
            }
        }

        return redirect()
            ->to(localized_route('contact'))
            ->with('status', 'Mensaje enviado. Te responderemos en cuanto sea posible.');
    }

    public function faq()
    {
        $page = Page::where('slug', 'faq')->first();

        return view('site.page', compact('page'));
    }

    public function blog()
    {
        $posts = \App\Models\BlogPost::where('published', true)
            ->where('published_at', '<=', now())
            ->orderBy('order')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('site.blog.index', compact('posts'));
    }
    
    public function blogPost($slug)
    {
        $post = \App\Models\BlogPost::where('slug', $slug)
            ->where('published', true)
            ->where('published_at', '<=', now())
            ->firstOrFail();

        return view('site.blog.show', compact('post'));
    }

    public function photosReaders()
    {
        // Solo mostrar fotos generales (sin libro específico)
        $photos = \App\Models\ReaderPhoto::where('active', true)
            ->whereNull('book_id')
            ->orderBy('order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('site.photos-readers', compact('photos'));
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

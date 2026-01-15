<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Page;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $books = Book::where('active', true)->get();
        $pages = Page::whereIn('slug', ['about', 'contact', 'faq', 'blog', 'offers', 'photos-readers', 'photos-books'])->get();
        
        $locales = ['es', 'ca', 'en'];
        $baseUrl = url('/');
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">' . "\n";
        
        // Página principal
        foreach ($locales as $locale) {
            $url = $locale === 'es' ? $baseUrl : $baseUrl . '/' . $locale;
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url) . '</loc>' . "\n";
            $xml .= '    <changefreq>weekly</changefreq>' . "\n";
            $xml .= '    <priority>1.0</priority>' . "\n";
            foreach ($locales as $altLocale) {
                $altUrl = $altLocale === 'es' ? $baseUrl : $baseUrl . '/' . $altLocale;
                $xml .= '    <xhtml:link rel="alternate" hreflang="' . $altLocale . '" href="' . htmlspecialchars($altUrl) . '" />' . "\n";
            }
            $xml .= '  </url>' . "\n";
        }
        
        // Páginas estáticas
        foreach ($pages as $page) {
            foreach ($locales as $locale) {
                $url = $locale === 'es' 
                    ? $baseUrl . '/' . $page->slug 
                    : $baseUrl . '/' . $locale . '/' . $page->slug;
                $xml .= '  <url>' . "\n";
                $xml .= '    <loc>' . htmlspecialchars($url) . '</loc>' . "\n";
                $xml .= '    <changefreq>monthly</changefreq>' . "\n";
                $xml .= '    <priority>0.8</priority>' . "\n";
                foreach ($locales as $altLocale) {
                    $altUrl = $altLocale === 'es' 
                        ? $baseUrl . '/' . $page->slug 
                        : $baseUrl . '/' . $altLocale . '/' . $page->slug;
                    $xml .= '    <xhtml:link rel="alternate" hreflang="' . $altLocale . '" href="' . htmlspecialchars($altUrl) . '" />' . "\n";
                }
                $xml .= '  </url>' . "\n";
            }
        }
        
        // Libros
        foreach ($books as $book) {
            foreach ($locales as $locale) {
                $url = $locale === 'es' 
                    ? $baseUrl . '/books/' . $book->id 
                    : $baseUrl . '/' . $locale . '/books/' . $book->id;
                $xml .= '  <url>' . "\n";
                $xml .= '    <loc>' . htmlspecialchars($url) . '</loc>' . "\n";
                $xml .= '    <changefreq>monthly</changefreq>' . "\n";
                $xml .= '    <priority>0.9</priority>' . "\n";
                foreach ($locales as $altLocale) {
                    $altUrl = $altLocale === 'es' 
                        ? $baseUrl . '/books/' . $book->id 
                        : $baseUrl . '/' . $altLocale . '/books/' . $book->id;
                    $xml .= '    <xhtml:link rel="alternate" hreflang="' . $altLocale . '" href="' . htmlspecialchars($altUrl) . '" />' . "\n";
                }
                $xml .= '  </url>' . "\n";
            }
        }
        
        $xml .= '</urlset>';
        
        return response($xml, 200)
            ->header('Content-Type', 'application/xml');
    }
}

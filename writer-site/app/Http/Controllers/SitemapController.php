<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BlogPost;
use App\Models\Page;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $books = Book::where('active', true)->get();
        $pages = Page::whereIn('slug', ['about', 'contact', 'faq', 'offers', 'photos-readers', 'photos-books'])->get();
        $blogPosts = BlogPost::where('published', true)
            ->where('published_at', '<=', now())
            ->get();
        
        $legalPages = [
            ['slug' => 'privacy', 'route' => 'legal.privacy'],
            ['slug' => 'terms', 'route' => 'legal.terms'],
            ['slug' => 'legal-notice', 'route' => 'legal.notice'],
            ['slug' => 'cookies', 'route' => 'legal.cookies'],
        ];
        
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
        
        // Blog posts
        foreach ($blogPosts as $post) {
            foreach ($locales as $locale) {
                $url = $locale === 'es' 
                    ? $baseUrl . '/blog/' . $post->slug 
                    : $baseUrl . '/' . $locale . '/blog/' . $post->slug;
                $xml .= '  <url>' . "\n";
                $xml .= '    <loc>' . htmlspecialchars($url) . '</loc>' . "\n";
                $xml .= '    <changefreq>weekly</changefreq>' . "\n";
                $xml .= '    <priority>0.8</priority>' . "\n";
                foreach ($locales as $altLocale) {
                    $altUrl = $altLocale === 'es' 
                        ? $baseUrl . '/blog/' . $post->slug 
                        : $baseUrl . '/' . $altLocale . '/blog/' . $post->slug;
                    $xml .= '    <xhtml:link rel="alternate" hreflang="' . $altLocale . '" href="' . htmlspecialchars($altUrl) . '" />' . "\n";
                }
                $xml .= '  </url>' . "\n";
            }
        }
        
        // Página del blog
        foreach ($locales as $locale) {
            $url = $locale === 'es' ? $baseUrl . '/blog' : $baseUrl . '/' . $locale . '/blog';
            $xml .= '  <url>' . "\n";
            $xml .= '    <loc>' . htmlspecialchars($url) . '</loc>' . "\n";
            $xml .= '    <changefreq>weekly</changefreq>' . "\n";
            $xml .= '    <priority>0.8</priority>' . "\n";
            foreach ($locales as $altLocale) {
                $altUrl = $altLocale === 'es' ? $baseUrl . '/blog' : $baseUrl . '/' . $altLocale . '/blog';
                $xml .= '    <xhtml:link rel="alternate" hreflang="' . $altLocale . '" href="' . htmlspecialchars($altUrl) . '" />' . "\n";
            }
            $xml .= '  </url>' . "\n";
        }
        
        // Páginas legales
        foreach ($legalPages as $legalPage) {
            foreach ($locales as $locale) {
                $url = $locale === 'es' 
                    ? $baseUrl . '/' . $legalPage['slug'] 
                    : $baseUrl . '/' . $locale . '/' . $legalPage['slug'];
                $xml .= '  <url>' . "\n";
                $xml .= '    <loc>' . htmlspecialchars($url) . '</loc>' . "\n";
                $xml .= '    <changefreq>monthly</changefreq>' . "\n";
                $xml .= '    <priority>0.5</priority>' . "\n";
                foreach ($locales as $altLocale) {
                    $altUrl = $altLocale === 'es' 
                        ? $baseUrl . '/' . $legalPage['slug'] 
                        : $baseUrl . '/' . $altLocale . '/' . $legalPage['slug'];
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

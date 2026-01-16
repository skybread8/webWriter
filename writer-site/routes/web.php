<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\BookStoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas públicas (web)
|--------------------------------------------------------------------------
|
| Rutas públicas con soporte multiidioma opcional
|
*/

// Sitemap y robots.txt (sin prefijo de idioma)
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', function () {
    $content = "User-agent: *\n";
    $content .= "Allow: /\n";
    $content .= "Disallow: /admin\n";
    $content .= "Disallow: /login\n";
    $content .= "Disallow: /register\n";
    $content .= "\n";
    $content .= "Sitemap: " . url('/sitemap.xml') . "\n";
    return response($content, 200)->header('Content-Type', 'text/plain');
})->name('robots');

// Redirigir raíz a /es/ (español por defecto)
Route::get('/', function () {
    return redirect('/es');
});

// Rutas públicas con prefijo de idioma obligatorio
Route::group(['prefix' => '{locale}', 'middleware' => ['web', \App\Http\Middleware\SetLocale::class], 'where' => ['locale' => 'es|ca|en']], function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/books', [BookStoreController::class, 'index'])->name('books.index.public');
    Route::get('/books/{book}', [BookStoreController::class, 'show'])->name('books.show');
    Route::post('/books/{book}/checkout', [BookStoreController::class, 'checkout'])->name('books.checkout');

    // Reseñas (requiere autenticación)
    Route::middleware('auth')->group(function () {
        Route::post('/books/{book}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
        Route::delete('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
    });

    // Carrito de compra
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{book}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{book}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout
    Route::get('/checkout', [BookStoreController::class, 'checkoutForm'])->name('checkout.index');
    Route::post('/checkout', [BookStoreController::class, 'checkoutCart'])->name('checkout.process');
    Route::get('/checkout/success', [BookStoreController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel', [BookStoreController::class, 'cancel'])->name('checkout.cancel');

    // Cuenta de usuario (requiere autenticación)
    Route::middleware('auth')->group(function () {
        Route::get('/account', [ProfileController::class, 'index'])->name('account.index');
        Route::get('/account/profile', [ProfileController::class, 'edit'])->name('account.profile');
        Route::patch('/account/profile', [ProfileController::class, 'update'])->name('account.profile.update');
        Route::delete('/account', [ProfileController::class, 'destroy'])->name('account.destroy');
        
        Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    });

    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');
    Route::get('/faq', [PageController::class, 'faq'])->name('faq');
    Route::get('/blog', [PageController::class, 'blog'])->name('blog');
    Route::get('/blog/{slug}', [PageController::class, 'blogPost'])->name('blog.post');
    Route::get('/photos-readers', [PageController::class, 'photosReaders'])->name('photos.readers');
    Route::get('/photos-books', [PageController::class, 'photosBooks'])->name('photos.books');
    Route::get('/offers', [PageController::class, 'offers'])->name('offers');

    // Páginas legales
    Route::get('/privacy', [\App\Http\Controllers\LegalController::class, 'privacy'])->name('legal.privacy');
    Route::get('/terms', [\App\Http\Controllers\LegalController::class, 'terms'])->name('legal.terms');
    Route::get('/legal-notice', [\App\Http\Controllers\LegalController::class, 'legalNotice'])->name('legal.notice');
    Route::get('/cookies', [\App\Http\Controllers\LegalController::class, 'cookies'])->name('legal.cookies');
});

/*
|--------------------------------------------------------------------------
| Rutas de panel de administración
|--------------------------------------------------------------------------
|
| Accesibles solo para el usuario admin, con un lenguaje sencillo
| para que alguien no técnico pueda gestionar todo el contenido.
|
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Portada (texto principal e imagen).
    Route::get('/home', [AdminHomeController::class, 'edit'])->name('home.edit');
    Route::post('/home', [AdminHomeController::class, 'update'])->name('home.update');

    // Libros (crear/editar/eliminar, precios e imágenes).
    Route::resource('books', AdminBookController::class)->except(['show']);
    Route::post('/books/update-order', [AdminBookController::class, 'updateOrder'])->name('books.update-order');

    // Testimonios (reviews con fotos).
    Route::resource('testimonials', AdminTestimonialController::class);
    Route::post('/testimonials/update-order', [AdminTestimonialController::class, 'updateOrder'])->name('testimonials.update-order');

    // Blog
    Route::resource('blog', \App\Http\Controllers\Admin\BlogPostController::class);
    Route::post('/blog/update-order', [\App\Http\Controllers\Admin\BlogPostController::class, 'updateOrder'])->name('blog.update-order');

    // Reseñas
    Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}/approve', [\App\Http\Controllers\Admin\ReviewController::class, 'approve'])->name('reviews.approve');
    Route::patch('/reviews/{review}/reject', [\App\Http\Controllers\Admin\ReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\Admin\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Páginas estáticas (about/contact).
    Route::get('/pages/about', [AdminPageController::class, 'editAbout'])->name('pages.about.edit');
    Route::post('/pages/about', [AdminPageController::class, 'updateAbout'])->name('pages.about.update');
    Route::get('/pages/contact', [AdminPageController::class, 'editContact'])->name('pages.contact.edit');
    Route::post('/pages/contact', [AdminPageController::class, 'updateContact'])->name('pages.contact.update');

    // Ajustes generales del sitio.
    Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SiteSettingController::class, 'update'])->name('settings.update');

    // Políticas legales
    Route::get('/legal', [\App\Http\Controllers\Admin\LegalController::class, 'edit'])->name('legal.edit');
    Route::post('/legal', [\App\Http\Controllers\Admin\LegalController::class, 'update'])->name('legal.update');
});

/*
|--------------------------------------------------------------------------
| Rutas de perfil generadas por Breeze
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

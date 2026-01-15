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
| Aquí irán la portada, listado de libros, detalle, about y contacto.
| De momento dejamos la ruta raíz apuntando a dashboard para comprobar
| que todo funciona; después la reemplazaremos por la home pública.
|
*/

// Sitemap y robots.txt
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

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/books', [BookStoreController::class, 'index'])->name('books.index.public');
Route::get('/books/{book}', [BookStoreController::class, 'show'])->name('books.show');
Route::post('/books/{book}/checkout', [BookStoreController::class, 'checkout'])->name('books.checkout');

// Carrito de compra
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/cart/update/{book}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{book}', [CartController::class, 'remove'])->name('cart.remove');
Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout
Route::post('/checkout', [BookStoreController::class, 'checkoutCart'])->name('checkout.index');
Route::get('/checkout/success', [BookStoreController::class, 'success'])->name('checkout.success');
Route::get('/checkout/cancel', [BookStoreController::class, 'cancel'])->name('checkout.cancel');

Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/photos-readers', [PageController::class, 'photosReaders'])->name('photos.readers');
Route::get('/photos-books', [PageController::class, 'photosBooks'])->name('photos.books');
Route::get('/offers', [PageController::class, 'offers'])->name('offers');

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

    // Testimonios (reviews con fotos).
    Route::resource('testimonials', AdminTestimonialController::class);

    // Páginas estáticas (about/contact).
    Route::get('/pages/about', [AdminPageController::class, 'editAbout'])->name('pages.about.edit');
    Route::post('/pages/about', [AdminPageController::class, 'updateAbout'])->name('pages.about.update');
    Route::get('/pages/contact', [AdminPageController::class, 'editContact'])->name('pages.contact.edit');
    Route::post('/pages/contact', [AdminPageController::class, 'updateContact'])->name('pages.contact.update');

    // Ajustes generales del sitio.
    Route::get('/settings', [SiteSettingController::class, 'edit'])->name('settings.edit');
    Route::post('/settings', [SiteSettingController::class, 'update'])->name('settings.update');
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

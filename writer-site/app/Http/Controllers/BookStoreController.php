<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class BookStoreController extends Controller
{
    public function index(): View
    {
        $books = Book::where('active', true)->orderBy('created_at', 'desc')->get();

        return view('store.books.index', compact('books'));
    }

    public function show(Book $book): View
    {
        abort_unless($book->active, 404);

        return view('store.books.show', compact('book'));
    }

    /**
     * Checkout directo de un solo libro (mantener compatibilidad)
     */
    public function checkout(Request $request, Book $book): RedirectResponse
    {
        abort_unless($book->active, 404);

        if (! $book->stripe_price_id || ! config('services.stripe.secret')) {
            return back()->with('status', 'El pago aún no está configurado para este libro.');
        }

        // Añadir al carrito y redirigir al checkout del carrito
        $cart = session()->get('cart', []);
        $cart[$book->id] = 1;
        session()->put('cart', $cart);

        return redirect()->route('checkout.index');
    }

    /**
     * Checkout desde el carrito (múltiples libros)
     */
    public function checkoutCart(): RedirectResponse
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('status', 'Tu carrito está vacío.');
        }

        if (! config('services.stripe.secret')) {
            return redirect()->route('cart.index')
                ->with('status', 'El sistema de pagos no está configurado.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];
        $books = Book::whereIn('id', array_keys($cart))
            ->where('active', true)
            ->get();

        foreach ($books as $book) {
            if (! $book->stripe_price_id) {
                continue;
            }

            $lineItems[] = [
                'price' => $book->stripe_price_id,
                'quantity' => $cart[$book->id] ?? 1,
            ];
        }

        if (empty($lineItems)) {
            return redirect()->route('cart.index')
                ->with('status', 'Algunos libros no tienen precio de Stripe configurado.');
        }

        $session = StripeSession::create([
            'mode' => 'payment',
            'line_items' => $lineItems,
            'success_url' => route('checkout.success').'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.cancel'),
        ]);

        return redirect()->away($session->url);
    }

    public function success(Request $request): View
    {
        // Limpiar el carrito después de una compra exitosa
        session()->forget('cart');

        return view('store.checkout.success');
    }

    public function cancel(Request $request): View
    {
        return view('store.checkout.cancel');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;

class BookStoreController extends Controller
{
    public function index(): View
    {
        $books = Book::where('active', true)->orderBy('order')->orderBy('created_at', 'desc')->get();

        return view('store.books.index', compact('books'));
    }

    public function show(Request $request, string $locale, $book): View
    {
        // Si $book es un string (ID), buscar el modelo
        if (is_string($book) || is_numeric($book)) {
            $book = Book::findOrFail($book);
        }
        
        // Si no es una instancia de Book, intentar obtenerla
        if (!($book instanceof Book)) {
            $book = Book::findOrFail($book);
        }
        
        abort_unless($book->active, 404);

        // Obtener reseña del usuario actual si está autenticado (puede estar pendiente de aprobación)
        $userReview = null;
        if (auth()->check()) {
            $userReview = $book->reviews()->where('user_id', auth()->id())->first();
        }

        // Cargar solo reseñas aprobadas para mostrar públicamente
        $reviews = $book->reviews()
            ->where('approved', true)
            ->with('user:id,name')
            ->orderByRaw('CASE WHEN user_id = ? THEN 0 ELSE 1 END', [auth()->id() ?? 0])
            ->latest()
            ->get();

        // Cargar fotos de lectores activas para este libro
        $readerPhotos = $book->readerPhotos()->where('active', true)->orderBy('order')->orderBy('created_at', 'desc')->get();

        return view('store.books.show', compact('book', 'reviews', 'userReview', 'readerPhotos'));
    }

    /**
     * Checkout directo de un solo libro (mantener compatibilidad)
     */
    public function checkout(Request $request, string $locale, $book): RedirectResponse
    {
        // Si $book es un string (ID), buscar el modelo
        if (is_string($book) || is_numeric($book)) {
            $book = Book::findOrFail($book);
        }
        
        // Si no es una instancia de Book, intentar obtenerla
        if (!($book instanceof Book)) {
            $book = Book::findOrFail($book);
        }
        
        abort_unless($book->active, 404);

        if (! $book->stripe_price_id || ! config('services.stripe.secret')) {
            return back()->with('status', 'El pago aún no está configurado para este libro.');
        }

        // Añadir al carrito y redirigir al checkout del carrito
        $cart = session()->get('cart', []);
        $cart[$book->id] = 1;
        session()->put('cart', $cart);

        return redirect()->to(localized_route('checkout.index'));
    }

    /**
     * Mostrar página de checkout (con opción de invitado o login)
     */
    public function checkoutForm(): View
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->to(localized_route('cart.index'))
                ->with('status', 'Tu carrito está vacío.');
        }

        $books = Book::whereIn('id', array_keys($cart))
            ->where('active', true)
            ->get();

        $total = 0;
        $cartItems = [];
        foreach ($books as $book) {
            $quantity = $cart[$book->id] ?? 1;
            $subtotal = $book->price * $quantity;
            $total += $subtotal;
            $cartItems[] = [
                'book' => $book,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ];
        }

        return view('store.checkout.form', compact('cartItems', 'total'));
    }

    /**
     * Procesar checkout (crear pedido y redirigir a Stripe)
     */
    public function checkoutCart(Request $request): RedirectResponse
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->to(localized_route('cart.index'))
                ->with('status', 'Tu carrito está vacío.');
        }

        if (! config('services.stripe.secret')) {
            return redirect()->to(localized_route('cart.index'))
                ->with('status', 'El sistema de pagos no está configurado.');
        }

        // Validar datos del cliente
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:20'],
            'customer_address' => ['required', 'string', 'max:255'],
            'customer_city' => ['required', 'string', 'max:100'],
            'customer_postal_code' => ['required', 'string', 'max:10'],
            'customer_province' => ['required', 'string', 'max:100'],
            'customer_country' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $lineItems = [];
        $books = Book::whereIn('id', array_keys($cart))
            ->where('active', true)
            ->get();

        $total = 0;
        foreach ($books as $book) {
            if (! $book->stripe_price_id) {
                continue;
            }

            $quantity = $cart[$book->id] ?? 1;
            $total += $book->price * $quantity;

            $lineItems[] = [
                'price' => $book->stripe_price_id,
                'quantity' => $quantity,
            ];
        }

        if (empty($lineItems)) {
            return redirect()->to(localized_route('cart.index'))
                ->with('status', 'Algunos libros no tienen precio de Stripe configurado.');
        }

        // Crear pedido antes de redirigir a Stripe
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => Order::generateOrderNumber(),
            'status' => 'pending',
            'total' => $total,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'customer_address' => $validated['customer_address'],
            'customer_city' => $validated['customer_city'],
            'customer_postal_code' => $validated['customer_postal_code'],
            'customer_province' => $validated['customer_province'],
            'customer_country' => $validated['customer_country'],
            'notes' => $validated['notes'] ?? null,
        ]);

        // Crear items del pedido
        foreach ($books as $book) {
            $quantity = $cart[$book->id] ?? 1;
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $book->id,
                'book_title' => $book->title,
                'book_price' => $book->price,
                'quantity' => $quantity,
                'subtotal' => $book->price * $quantity,
            ]);
        }

        // Crear sesión de Stripe
        $session = StripeSession::create([
            'mode' => 'payment',
            'line_items' => $lineItems,
            'success_url' => localized_route('checkout.success', [], true).'?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => localized_route('checkout.cancel', [], true),
            'customer_email' => $validated['customer_email'],
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ],
        ]);

        // Guardar session_id en el pedido
        $order->update(['stripe_session_id' => $session->id]);

        return redirect()->away($session->url);
    }

    public function success(Request $request): View
    {
        $sessionId = $request->query('session_id');
        
        if ($sessionId && config('services.stripe.secret')) {
            Stripe::setApiKey(config('services.stripe.secret'));
            
            try {
                $session = StripeSession::retrieve($sessionId);
                
                // Buscar el pedido por session_id
                $order = Order::where('stripe_session_id', $sessionId)->first();
                
                if ($order && $session->payment_status === 'paid') {
                    // Actualizar estado del pedido
                    $order->update(['status' => 'paid']);
                }
            } catch (\Exception $e) {
                // Si hay error al verificar, continuar de todas formas
                \Log::error('Error verificando sesión de Stripe: ' . $e->getMessage());
            }
        }

        // Limpiar el carrito después de una compra exitosa
        session()->forget('cart');

        return view('store.checkout.success', [
            'order' => $order ?? null,
        ]);
    }

    public function cancel(Request $request): View
    {
        return view('store.checkout.cancel');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    /**
     * Mostrar el carrito de compra
     */
    public function index(): View
    {
        $cart = session()->get('cart', []);
        $books = [];
        $total = 0;

        foreach ($cart as $bookId => $quantity) {
            $book = Book::with(['images' => function($query) {
                $query->orderBy('order')->orderBy('created_at')->limit(1);
            }])->find($bookId);
            if ($book && $book->active) {
                $maxQty = $book->hasStockControl() ? ($book->stock ?? 0) : null;
                $effectiveQty = $maxQty !== null ? min($quantity, $maxQty) : $quantity;
                $books[] = [
                    'id' => $book->id,
                    'title' => $book->title,
                    'price' => $book->price,
                    'image_url' => $book->first_image_url,
                    'quantity' => $effectiveQty,
                    'subtotal' => $book->price * $effectiveQty,
                    'in_stock' => $book->isInStock(),
                    'max_quantity' => $maxQty,
                ];
                $total += $book->price * $effectiveQty;
            }
        }

        return view('store.cart.index', compact('books', 'total'));
    }

    /**
     * Añadir libro al carrito
     */
    public function add(Request $request, string $locale, $book): RedirectResponse
    {
        // Si $book es un string (ID), buscar el modelo
        if (is_string($book) || is_numeric($book)) {
            $book = Book::findOrFail($book);
        }
        
        abort_unless($book->active, 404);

        if (! $book->isInStock()) {
            return back()->with('status', 'Este libro no está disponible (sin stock).');
        }

        $cart = session()->get('cart', []);
        $quantity = (int) $request->input('quantity', 1);

        if (isset($cart[$book->id])) {
            $cart[$book->id] += $quantity;
        } else {
            $cart[$book->id] = $quantity;
        }

        if ($book->hasStockControl() && $book->stock !== null) {
            $cart[$book->id] = min($cart[$book->id], $book->stock);
        }

        session()->put('cart', $cart);

        return redirect()
            ->to(localized_route('cart.index'))
            ->with('status', 'Libro añadido al carrito.');
    }

    /**
     * Actualizar cantidad de un libro en el carrito
     */
    public function update(Request $request, string $locale, $book): RedirectResponse
    {
        // Si $book es un string (ID), buscar el modelo
        if (is_string($book) || is_numeric($book)) {
            $book = Book::findOrFail($book);
        }
        
        $cart = session()->get('cart', []);
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            unset($cart[$book->id]);
        } else {
            if ($book->hasStockControl() && $book->stock !== null) {
                $quantity = min($quantity, $book->stock);
            }
            $cart[$book->id] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->to(localized_route('cart.index'));
    }

    /**
     * Eliminar libro del carrito
     */
    public function remove(string $locale, $book): RedirectResponse
    {
        // Si $book es un string (ID), buscar el modelo
        if (is_string($book) || is_numeric($book)) {
            $book = Book::findOrFail($book);
        }
        
        $cart = session()->get('cart', []);
        unset($cart[$book->id]);
        session()->put('cart', $cart);

        return redirect()->to(localized_route('cart.index'));
    }

    /**
     * Vaciar el carrito
     */
    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->to(localized_route('cart.index'));
    }
}

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
            $book = Book::find($bookId);
            if ($book && $book->active) {
                $books[] = [
                    'id' => $book->id,
                    'title' => $book->title,
                    'price' => $book->price,
                    'cover_image' => $book->cover_image,
                    'quantity' => $quantity,
                    'subtotal' => $book->price * $quantity,
                ];
                $total += $book->price * $quantity;
            }
        }

        return view('store.cart.index', compact('books', 'total'));
    }

    /**
     * Añadir libro al carrito
     */
    public function add(Request $request, Book $book): RedirectResponse
    {
        abort_unless($book->active, 404);

        $cart = session()->get('cart', []);
        $quantity = (int) $request->input('quantity', 1);

        if (isset($cart[$book->id])) {
            $cart[$book->id] += $quantity;
        } else {
            $cart[$book->id] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()
            ->route('cart.index')
            ->with('status', 'Libro añadido al carrito.');
    }

    /**
     * Actualizar cantidad de un libro en el carrito
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $cart = session()->get('cart', []);
        $quantity = (int) $request->input('quantity', 1);

        if ($quantity <= 0) {
            unset($cart[$book->id]);
        } else {
            $cart[$book->id] = $quantity;
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    /**
     * Eliminar libro del carrito
     */
    public function remove(Book $book): RedirectResponse
    {
        $cart = session()->get('cart', []);
        unset($cart[$book->id]);
        session()->put('cart', $cart);

        return redirect()->route('cart.index');
    }

    /**
     * Vaciar el carrito
     */
    public function clear(): RedirectResponse
    {
        session()->forget('cart');

        return redirect()->route('cart.index');
    }
}

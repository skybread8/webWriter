<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Mostrar todos los pedidos del usuario
     */
    public function index(string $locale): View
    {
        $orders = auth()->user()->orders()
            ->with(['items.book' => function($query) {
                $query->with(['images' => function($q) {
                    $q->orderBy('order')->orderBy('created_at')->limit(1);
                }]);
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Mostrar un pedido específico
     */
    public function show(string $locale, Order $order): View
    {
        // Verificar que el pedido pertenece al usuario
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['items.book' => function($query) {
            $query->with(['images' => function($q) {
                $q->orderBy('order')->orderBy('created_at')->limit(1);
            }]);
        }]);

        return view('orders.show', compact('order'));
    }
}

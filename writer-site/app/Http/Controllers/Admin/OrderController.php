<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Listar todos los pedidos
     */
    public function index(Request $request): View
    {
        app()->setLocale('es');
        
        $query = Order::with(['user', 'items.book' => function($query) {
            $query->with(['images' => function($q) {
                $q->orderBy('order')->orderBy('created_at')->limit(1);
            }]);
        }])->orderBy('created_at', 'desc');

        // Filtros
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        if ($request->has('shipped') && $request->shipped !== '') {
            $query->where('shipped', $request->shipped === '1');
        }

        if ($request->has('refunded') && $request->refunded !== '') {
            $query->where('refunded', $request->refunded === '1');
        }

        if ($request->has('search') && $request->search !== '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(20)->withQueryString();

        // Estadísticas
        $totalOrders = Order::count();
        $pendingShipments = Order::where('status', 'paid')->where('shipped', false)->count();
        $shippedOrders = Order::where('shipped', true)->count();
        $refundedOrders = Order::where('refunded', true)->count();

        return view('admin.orders.index', compact('orders', 'totalOrders', 'pendingShipments', 'shippedOrders', 'refundedOrders'));
    }

    /**
     * Mostrar detalles de un pedido
     */
    public function show(Order $order): View
    {
        app()->setLocale('es');
        
        $order->load(['user', 'items.book' => function($query) {
            $query->with(['images' => function($q) {
                $q->orderBy('order')->orderBy('created_at')->limit(1);
            }]);
        }]);

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Marcar pedido como enviado
     */
    public function markAsShipped(Request $request, Order $order): RedirectResponse
    {
        app()->setLocale('es');
        
        // NO cambiar el status - mantener 'paid' para que siga contando en ingresos
        // Solo actualizar el flag shipped y la fecha de envío
        $order->update([
            'shipped' => true,
            'shipped_at' => now(),
            // Mantener el status como 'paid' o cambiarlo a 'shipped' solo para tracking,
            // pero el cálculo de ingresos incluirá ambos
        ]);

        // Enviar correo de pedido enviado
        try {
            \Mail::to($order->customer_email)->send(new \App\Mail\OrderShippedMail($order));
        } catch (\Exception $e) {
            \Log::error('Error enviando correo de pedido enviado: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('status', 'Pedido marcado como enviado correctamente.');
    }

    /**
     * Marcar pedido como no enviado
     */
    public function markAsNotShipped(Request $request, Order $order): RedirectResponse
    {
        app()->setLocale('es');
        
        // Mantener el status como 'paid' (no cambiar)
        $order->update([
            'shipped' => false,
            'shipped_at' => null,
            // No cambiar el status, mantenerlo como estaba (probablemente 'paid')
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('status', 'Pedido marcado como no enviado.');
    }

    /**
     * Procesar devolución
     */
    public function processRefund(Request $request, Order $order): RedirectResponse
    {
        app()->setLocale('es');
        
        $data = $request->validate([
            'refund_amount' => ['required', 'numeric', 'min:0', 'max:' . $order->total],
            'refund_reason' => ['required', 'string', 'max:1000'],
        ], [
            'refund_amount.required' => 'Debes indicar el importe a devolver.',
            'refund_amount.numeric' => 'El importe debe ser un número válido.',
            'refund_amount.min' => 'El importe no puede ser negativo.',
            'refund_amount.max' => 'El importe no puede ser mayor al total del pedido.',
            'refund_reason.required' => 'Debes indicar el motivo de la devolución.',
            'refund_reason.max' => 'El motivo no puede tener más de 1000 caracteres.',
        ]);

        $order->update([
            'refunded' => true,
            'refunded_at' => now(),
            'refund_amount' => $data['refund_amount'],
            'refund_reason' => $data['refund_reason'],
            'status' => 'cancelled',
        ]);

        // Enviar correo de devolución
        try {
            \Mail::to($order->customer_email)->send(new \App\Mail\OrderRefundedMail($order));
        } catch (\Exception $e) {
            \Log::error('Error enviando correo de devolución: ' . $e->getMessage());
        }

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('status', 'Devolución procesada correctamente. Recuerda realizar el reembolso en Stripe si es necesario.');
    }

    /**
     * Cancelar devolución
     */
    public function cancelRefund(Request $request, Order $order): RedirectResponse
    {
        app()->setLocale('es');
        
        $order->update([
            'refunded' => false,
            'refunded_at' => null,
            'refund_amount' => null,
            'refund_reason' => null,
            'status' => $order->shipped ? 'shipped' : 'paid',
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('status', 'Devolución cancelada correctamente.');
    }
}

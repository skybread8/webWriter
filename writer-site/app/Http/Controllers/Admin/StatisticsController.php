<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\SentEmail;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StatisticsController extends Controller
{
    /**
     * Mostrar página de estadísticas
     */
    public function index(): View
    {
        // Estadísticas de visitas
        $totalVisits = Visit::count();
        $visitsToday = Visit::whereDate('visited_at', today())->count();
        $visitsThisWeek = Visit::where('visited_at', '>=', now()->startOfWeek())->count();
        $visitsThisMonth = Visit::where('visited_at', '>=', now()->startOfMonth())->count();
        
        // Páginas más visitadas (sin prefijo de idioma)
        $allVisits = Visit::where('path', '!=', '/')
            ->where('path', 'NOT LIKE', 'es')
            ->where('path', 'NOT LIKE', 'ca')
            ->where('path', 'NOT LIKE', 'en')
            ->get();
        
        // Mapeo de paths a nombres traducidos
        $pathTranslations = [
            'books' => 'Libros',
            'about' => 'Sobre mí',
            'offers' => 'Ofertas',
            'photos-readers' => 'Fotos con lectores',
            'photos-books' => 'Fotos con novelas',
            'blog' => 'Blog',
            'contact' => 'Contacto',
            'cart' => 'Carrito',
            'checkout' => 'Pago',
            'home' => 'Inicio',
        ];
        
        // Procesar paths para eliminar prefijo de idioma
        $pathCounts = [];
        foreach ($allVisits as $visit) {
            $path = $visit->path;
            // Eliminar prefijo de idioma (es/, ca/, en/)
            if (preg_match('/^(es|ca|en)\/(.+)$/', $path, $matches)) {
                $cleanPath = $matches[2];
            } else {
                $cleanPath = $path;
            }
            
            // Traducir el path
            $translatedPath = $pathTranslations[$cleanPath] ?? ucfirst(str_replace('-', ' ', $cleanPath));
            
            if (!isset($pathCounts[$translatedPath])) {
                $pathCounts[$translatedPath] = 0;
            }
            $pathCounts[$translatedPath]++;
        }
        
        // Ordenar por visitas y tomar top 10
        arsort($pathCounts);
        $topPages = collect(array_slice($pathCounts, 0, 10, true))->map(function ($visits, $path) {
            return (object) [
                'path' => $path ?: '/',
                'visits' => $visits
            ];
        })->values();

        // Estadísticas de pedidos
        $totalOrders = Order::count();
        $ordersToday = Order::whereDate('created_at', today())->count();
        $ordersThisWeek = Order::where('created_at', '>=', now()->startOfWeek())->count();
        $ordersThisMonth = Order::where('created_at', '>=', now()->startOfMonth())->count();
        
        // Ingresos totales - pedidos pagados (status 'paid') o enviados/entregados ('shipped', 'delivered')
        // NO incluir 'pending' ni 'cancelled'
        // Excluir pedidos devueltos
        $totalRevenue = Order::whereIn('status', ['paid', 'shipped', 'delivered'])
            ->where('refunded', false)
            ->sum('total');
        $revenueThisMonth = Order::whereIn('status', ['paid', 'shipped', 'delivered'])
            ->where('refunded', false)
            ->where('created_at', '>=', now()->startOfMonth())
            ->sum('total');
        
        // Pedidos pendientes de envío
        $pendingShipments = Order::where('status', 'paid')
            ->where('shipped', false)
            ->with('items.book')
            ->orderBy('created_at', 'asc')
            ->get();
        
        // Pedidos enviados
        $shippedOrders = Order::where('shipped', true)
            ->with('items.book')
            ->orderBy('shipped_at', 'desc')
            ->limit(10)
            ->get();

        // Estadísticas de emails recibidos (mensajes de contacto)
        $totalEmails = ContactMessage::count();
        $emailsToday = ContactMessage::whereDate('created_at', today())->count();
        $emailsThisWeek = ContactMessage::where('created_at', '>=', now()->startOfWeek())->count();
        $emailsThisMonth = ContactMessage::where('created_at', '>=', now()->startOfMonth())->count();
        $unreadEmails = ContactMessage::where('read', false)->count();

        // Estadísticas de emails enviados
        $totalSentEmails = SentEmail::where('sent', true)->count();
        $sentEmailsToday = SentEmail::where('sent', true)->whereDate('sent_at', today())->count();
        $sentEmailsThisWeek = SentEmail::where('sent', true)->where('sent_at', '>=', now()->startOfWeek())->count();
        $sentEmailsThisMonth = SentEmail::where('sent', true)->where('sent_at', '>=', now()->startOfMonth())->count();
        $failedEmails = SentEmail::where('sent', false)->count();

        // Estadísticas de libros
        $totalBooks = Book::count();
        $activeBooks = Book::where('active', true)->count();
        $booksSold = Order::where('status', 'paid')
            ->with('items')
            ->get()
            ->sum(function ($order) {
                return $order->items->sum('quantity');
            });

        // Gráfico de visitas últimos 30 días
        $visitsLast30Days = Visit::where('visited_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(visited_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // Gráfico de pedidos últimos 30 días
        $ordersLast30Days = Order::where('created_at', '>=', now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        return view('admin.statistics.index', compact(
            'totalVisits',
            'visitsToday',
            'visitsThisWeek',
            'visitsThisMonth',
            'topPages',
            'totalOrders',
            'ordersToday',
            'ordersThisWeek',
            'ordersThisMonth',
            'totalRevenue',
            'revenueThisMonth',
            'pendingShipments',
            'shippedOrders',
            'totalEmails',
            'emailsToday',
            'emailsThisWeek',
            'emailsThisMonth',
            'unreadEmails',
            'totalSentEmails',
            'sentEmailsToday',
            'sentEmailsThisWeek',
            'sentEmailsThisMonth',
            'failedEmails',
            'totalBooks',
            'activeBooks',
            'booksSold',
            'visitsLast30Days',
            'ordersLast30Days'
        ));
    }

    /**
     * Marcar pedido como enviado
     */
    public function markAsShipped(Request $request, Order $order)
    {
        app()->setLocale('es');
        
        // NO cambiar el status - mantener 'paid' para que siga contando en ingresos
        // Solo actualizar el flag shipped y la fecha de envío
        $order->update([
            'shipped' => true,
            'shipped_at' => now(),
            // Mantener el status como 'paid' - el cálculo de ingresos incluirá ambos 'paid' y 'shipped'
        ]);

        return redirect()
            ->route('admin.statistics.index')
            ->with('status', 'Pedido marcado como enviado correctamente.');
    }

    /**
     * Marcar pedido como no enviado
     */
    public function markAsNotShipped(Request $request, Order $order)
    {
        app()->setLocale('es');
        
        // Mantener el status como estaba (probablemente 'paid')
        $order->update([
            'shipped' => false,
            'shipped_at' => null,
            // No cambiar el status, mantenerlo como estaba
        ]);

        return redirect()
            ->route('admin.statistics.index')
            ->with('status', 'Pedido marcado como no enviado.');
    }
}

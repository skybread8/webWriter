<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Console\Command;

class CreateExampleOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:create-example';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea pedidos de ejemplo: uno enviado y uno pendiente de envío';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Buscar un libro activo para el ejemplo
        $book = Book::where('active', true)->first();
        
        if (!$book) {
            $this->warn('No hay libros activos. Creando un pedido de ejemplo sin libro.');
            $book = null;
        }

        // Crear pedido de ejemplo con envío (debe estar como 'paid' primero para contarlo en ingresos)
        $order = Order::create([
            'user_id' => null, // Pedido como invitado
            'order_number' => Order::generateOrderNumber(),
            'status' => 'paid', // Primero como 'paid' para que se cuente en ingresos
            'total' => $book ? ($book->price * 2) : 25.99,
            'customer_name' => 'María García López',
            'customer_email' => 'maria.garcia@example.com',
            'customer_phone' => '+34 612 345 678',
            'customer_address' => 'Calle Mayor, 15, 3º B',
            'customer_city' => 'Madrid',
            'customer_postal_code' => '28001',
            'customer_province' => 'Madrid',
            'customer_country' => 'España',
            'notes' => 'Entregar en horario de mañana si es posible.',
            'shipped' => true,
            'shipped_at' => now()->subDays(2),
        ]);

        // Crear items del pedido
        if ($book) {
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => $book->id,
                'book_title' => $book->title,
                'book_price' => $book->price,
                'quantity' => 2,
                'subtotal' => $book->price * 2,
            ]);
        } else {
            // Si no hay libro, crear un item ficticio
            OrderItem::create([
                'order_id' => $order->id,
                'book_id' => null,
                'book_title' => 'Libro de ejemplo',
                'book_price' => 25.99,
                'quantity' => 1,
                'subtotal' => 25.99,
            ]);
        }

        $this->info("✓ Pedido enviado creado: {$order->order_number}");
        $this->info("✓ Pedido marcado como enviado el: {$order->shipped_at->format('d/m/Y H:i')}");
        $this->info("✓ Cliente: {$order->customer_name} ({$order->customer_email})");
        $this->info("✓ Total: " . number_format($order->total, 2) . " €");
        
        // Crear también un pedido pendiente de envío
        $pendingOrder = Order::create([
            'user_id' => null,
            'order_number' => Order::generateOrderNumber(),
            'status' => 'paid',
            'total' => $book ? $book->price : 19.99,
            'customer_name' => 'Juan Pérez Martínez',
            'customer_email' => 'juan.perez@example.com',
            'customer_phone' => '+34 623 456 789',
            'customer_address' => 'Avenida de la Paz, 42, 1º A',
            'customer_city' => 'Barcelona',
            'customer_postal_code' => '08001',
            'customer_province' => 'Barcelona',
            'customer_country' => 'España',
            'notes' => 'Llamar antes de entregar.',
            'shipped' => false,
            'shipped_at' => null,
        ]);

        if ($book) {
            OrderItem::create([
                'order_id' => $pendingOrder->id,
                'book_id' => $book->id,
                'book_title' => $book->title,
                'book_price' => $book->price,
                'quantity' => 1,
                'subtotal' => $book->price,
            ]);
        } else {
            OrderItem::create([
                'order_id' => $pendingOrder->id,
                'book_id' => null,
                'book_title' => 'Libro de ejemplo',
                'book_price' => 19.99,
                'quantity' => 1,
                'subtotal' => 19.99,
            ]);
        }

        $this->info("");
        $this->info("✓ Pedido pendiente creado: {$pendingOrder->order_number}");
        $this->info("✓ Cliente: {$pendingOrder->customer_name} ({$pendingOrder->customer_email})");
        $this->info("✓ Total: " . number_format($pendingOrder->total, 2) . " €");
        $this->info("✓ Estado: Pendiente de envío");
        
        return Command::SUCCESS;
    }
}

<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Seeder;

class ExampleOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buscar un libro activo para el ejemplo
        $book = Book::where('active', true)->first();
        
        if (!$book) {
            $this->command->warn('No hay libros activos. Creando un pedido de ejemplo sin libro.');
            $book = null;
        }

        // Crear pedido de ejemplo con envío
        $order = Order::create([
            'user_id' => null, // Pedido como invitado
            'order_number' => Order::generateOrderNumber(),
            'status' => 'shipped',
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

        $this->command->info("Pedido de ejemplo creado: {$order->order_number}");
        $this->command->info("Pedido marcado como enviado el: {$order->shipped_at->format('d/m/Y H:i')}");
    }
}

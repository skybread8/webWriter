<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [
            [
                'key' => 'order_created',
                'name' => 'Pedido Creado',
                'subject' => 'Pedido {{order_number}} recibido',
                'body' => "Hola {{customer_name}},\n\nHemos recibido tu pedido {{order_number}}.\n\nTotal: {{total}}\nFecha: {{order_date}}\n\nTe notificaremos cuando el pago sea confirmado.\n\nGracias por tu compra.",
                'active' => true,
            ],
            [
                'key' => 'order_paid',
                'name' => 'Pedido Pagado',
                'subject' => 'Pago confirmado - Pedido {{order_number}}',
                'body' => "Hola {{customer_name}},\n\n¡Gracias por tu compra! Hemos confirmado el pago de tu pedido {{order_number}}.\n\nTotal pagado: {{total}}\n\nTe notificaremos cuando tu pedido sea enviado.\n\nGracias.",
                'active' => true,
            ],
            [
                'key' => 'order_shipped',
                'name' => 'Pedido Enviado',
                'subject' => 'Pedido {{order_number}} enviado',
                'body' => "Hola {{customer_name}},\n\n¡Buenas noticias! Tu pedido {{order_number}} ha sido enviado.\n\nFecha de envío: {{shipped_date}}\n\nPronto recibirás tu pedido en la dirección indicada.\n\nGracias.",
                'active' => true,
            ],
            [
                'key' => 'order_refunded',
                'name' => 'Pedido Devuelto',
                'subject' => 'Devolución procesada - Pedido {{order_number}}',
                'body' => "Hola {{customer_name}},\n\nHemos procesado la devolución de tu pedido {{order_number}}.\n\nImporte devuelto: {{refund_amount}}\nMotivo: {{refund_reason}}\n\nEl reembolso se procesará en tu método de pago original en los próximos días.\n\nGracias.",
                'active' => true,
            ],
            [
                'key' => 'user_registered',
                'name' => 'Usuario Registrado',
                'subject' => 'Bienvenido a ' . config('app.name'),
                'body' => "Hola {{user_name}},\n\n¡Bienvenido a " . config('app.name') . "!\n\nTu cuenta ha sido creada correctamente. Ya puedes iniciar sesión y realizar compras.\n\nGracias por unirte a nosotros.",
                'active' => true,
            ],
            [
                'key' => 'password_reset',
                'name' => 'Restablecer Contraseña',
                'subject' => 'Restablecer contraseña',
                'body' => "Has solicitado restablecer tu contraseña.\n\nHaz clic en el siguiente enlace para restablecer tu contraseña:\n\n{{reset_url}}\n\nEste enlace expirará en 60 minutos.\n\nSi no solicitaste este cambio, puedes ignorar este correo.",
                'active' => true,
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['key' => $template['key']],
                $template
            );
        }
    }
}

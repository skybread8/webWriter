@php
    $template = $template ?? null;
    $variables = [
        'order_number' => $order->order_number,
        'customer_name' => $order->customer_name,
        'total' => number_format($order->total, 2, ',', '.') . ' €',
    ];
@endphp

@if($template)
    {!! nl2br(e($template->replaceVariables($variables))) !!}
@else
    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Hola {{ $order->customer_name }},
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        ¡Gracias por tu compra! Hemos confirmado el pago de tu pedido <strong>{{ $order->order_number }}</strong>.
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        <strong>Total pagado:</strong> {{ number_format($order->total, 2, ',', '.') }} €
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Te notificaremos cuando tu pedido sea enviado.
    </p>
@endif

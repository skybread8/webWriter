@php
    $template = $template ?? null;
    $variables = [
        'order_number' => $order->order_number,
        'customer_name' => $order->customer_name,
        'customer_email' => $order->customer_email,
        'total' => number_format($order->total, 2, ',', '.') . ' €',
        'order_date' => $order->created_at->format('d/m/Y H:i'),
    ];
@endphp

@if($template)
    {!! nl2br(e($template->replaceVariables($variables))) !!}
@else
    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Hola {{ $order->customer_name }},
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Hemos recibido tu pedido <strong>{{ $order->order_number }}</strong>.
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        <strong>Total:</strong> {{ number_format($order->total, 2, ',', '.') }} €<br>
        <strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Te notificaremos cuando el pago sea confirmado.
    </p>
@endif

@php
    $template = $template ?? null;
    $variables = [
        'order_number' => $order->order_number,
        'customer_name' => $order->customer_name,
        'refund_amount' => number_format($order->refund_amount ?? 0, 2, ',', '.') . ' €',
        'refund_reason' => $order->refund_reason ?? 'No especificado',
    ];
@endphp

@if($template)
    {!! nl2br(e($template->replaceVariables($variables))) !!}
@else
    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Hola {{ $order->customer_name }},
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Hemos procesado la devolución de tu pedido <strong>{{ $order->order_number }}</strong>.
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        <strong>Importe devuelto:</strong> {{ number_format($order->refund_amount ?? 0, 2, ',', '.') }} €<br>
        <strong>Motivo:</strong> {{ $order->refund_reason ?? 'No especificado' }}
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        El reembolso se procesará en tu método de pago original en los próximos días.
    </p>
@endif

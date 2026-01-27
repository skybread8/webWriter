@php
    $template = $template ?? null;
    $variables = [
        'order_number' => $order->order_number,
        'customer_name' => $order->customer_name,
        'shipped_date' => $order->shipped_at ? $order->shipped_at->format('d/m/Y') : now()->format('d/m/Y'),
    ];
@endphp

@if($template)
    {!! nl2br(e($template->replaceVariables($variables))) !!}
@else
    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Hola {{ $order->customer_name }},
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        ¡Buenas noticias! Tu pedido <strong>{{ $order->order_number }}</strong> ha sido enviado.
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        <strong>Fecha de envío:</strong> {{ $order->shipped_at ? $order->shipped_at->format('d/m/Y') : now()->format('d/m/Y') }}
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Pronto recibirás tu pedido en la dirección indicada.
    </p>
@endif

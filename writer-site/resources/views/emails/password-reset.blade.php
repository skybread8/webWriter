@php
    $template = $template ?? null;
@endphp

@if($template)
    {!! nl2br(e($template->replaceVariables(['reset_url' => $url]))) !!}
@else
    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Has solicitado restablecer tu contraseña.
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Haz clic en el siguiente enlace para restablecer tu contraseña:
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        <a href="{{ $url }}" style="color: #3b82f6; text-decoration: underline;">{{ $url }}</a>
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Este enlace expirará en 60 minutos.
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Si no solicitaste este cambio, puedes ignorar este correo.
    </p>
@endif

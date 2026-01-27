@php
    $template = $template ?? null;
    $variables = [
        'user_name' => $user->name,
        'user_email' => $user->email,
    ];
@endphp

@if($template)
    {!! nl2br(e($template->replaceVariables($variables))) !!}
@else
    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Hola {{ $user->name }},
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        ¡Bienvenido a {{ config('app.name') }}!
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Tu cuenta ha sido creada correctamente. Ya puedes iniciar sesión y realizar compras.
    </p>

    <p style="font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; font-size: 14px; color: #111827;">
        Gracias por unirte a nosotros.
    </p>
@endif

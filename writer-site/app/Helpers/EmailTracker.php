<?php

if (!function_exists('track_sent_email')) {
    /**
     * Registra un email enviado en la base de datos
     */
    function track_sent_email(string $type, string $toEmail, ?string $subject = null, ?string $content = null, bool $sent = true, ?string $error = null): void
    {
        try {
            \App\Models\SentEmail::create([
                'type' => $type,
                'to_email' => $toEmail,
                'subject' => $subject,
                'content' => $content ? substr($content, 0, 1000) : null, // Limitar contenido
                'sent' => $sent,
                'error' => $error,
                'sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Si falla el tracking, no interrumpir el envío
            \Log::warning('Failed to track sent email: ' . $e->getMessage());
        }
    }
}

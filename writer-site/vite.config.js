import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        https: process.env.APP_ENV === 'production',
    },
    build: {
        // Asegurar que los assets se generen con URLs absolutas si es necesario
        assetsDir: 'assets',
    },
});

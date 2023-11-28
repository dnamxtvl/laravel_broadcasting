import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/loading.css',
                'resources/css/toast.css',
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/toast.js',
                'resources/js/chat.js',
            ],
            refresh: true,
        }),
    ],
});

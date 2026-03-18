import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            input: [
            'resources/css/app.css',
            'resources/js/app.js',
            'resources/css/admin.css',    // CSS khusus admin
            'resources/js/admin.js',      // JS khusus admin
            ],    
            refresh: true,
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
    
});

import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    base: './',
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/react-app.jsx',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        react(),
    ],
});

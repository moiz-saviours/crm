import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig(({ mode }) => {
    // Load environment variables based on the current mode (development/production)
    const env = loadEnv(mode, process.cwd(), '');
    let base = './';
    if (env.APP_ENV === 'production') {
        base = '/';
    } else if (env.APP_ENV === 'development') {
        base = '/crm-development/';
    }
    return {
        base: env.VITE_BASE_URL || base,
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
    };
});

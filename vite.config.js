import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig(({ mode }) => {
    // Load environment variables based on the current mode (development/production)
    const env = loadEnv(mode, process.cwd(), '');
    const appEnv = env.APP_ENV || mode;
    let base = './';
    let socketPath = '/socket.io/';
    if (env.APP_ENV === 'production') {
        base = '/';
        socketPath = '/socket.io/';
    } else if (env.APP_ENV === 'development') {
        base = '/crm-development/';
        socketPath = '/crm-development/socket.io/';
    }
    return {
        base: env.VITE_BASE_URL || base,
        define: {
            'import.meta.env.VITE_APP_ENV': JSON.stringify(appEnv),
            'import.meta.env.VITE_SOCKET_PATH': JSON.stringify(socketPath),
            'import.meta.env.VITE_SOCKET_URL': JSON.stringify(env.SOCKETIO_URL || 'http://localhost:6001'),
        },
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

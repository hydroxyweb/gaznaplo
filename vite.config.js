import { VitePWA } from 'vite-plugin-pwa';
import { defineConfig } from 'vite';
import leaf from '@leafphp/vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        tailwindcss(),
        leaf({
            input: ['app/views/js/app.js'],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        VitePWA({
            registerType: 'autoUpdate',
            includeAssets: ['favicon.ico', 'apple-touch-icon.png', 'masked-icon.svg'],
            manifest: {
                lang: 'hu',
                name: 'GázNapló',
                short_name: 'GázNapló',
                description: 'Gázóra mérőállás rögzítése, és fogyasztás nyomonkövetése.',
                theme_color: '#2563eb',
                background_color: '#f8fafc',
                display: 'standalone',
                orientation: 'portrait',
                start_url: '/',
                icons: [
                {
                    src: '/favicon/android-chrome-192x192.png',
                    sizes: '192x192',
                    type: 'image/png'
                },
                {
                    src: '/favicon/android-chrome-512x512.png',
                    sizes: '512x512',
                    type: 'image/png'
                },
                {
                    src: '/favicon/android-chrome-512x512.png',
                    sizes: '512x512',
                    type: 'image/png',
                    purpose: 'any maskable'
                }
                ]
            },
            manifestLocales: {
                hu: {
                    lang: 'en',
                    name: 'GasNote',
                    short_name: 'GasNote',
                    description: 'Track and compare your monthly gas consumption',
                }
            }
        }),
    ],
    resolve: {
        alias: {
            '@': '/app/views/js',
        },
    },
});

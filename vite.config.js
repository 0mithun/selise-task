import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
const path = require('path')

import vue from '@vitejs/plugin-vue'
var env = loadEnv('all', process.cwd(), '')
// console.log(env)

export default defineConfig({
    server: {
        hmr: {
            host: 'localhost',
        },
    },
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel({
            input: ['resources/css/app.css', 'resources/css/flags.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            "@image": path.resolve(__dirname, '/resources/images'),
            "@css": path.resolve(__dirname, '/resources/css'),
            '@': path.resolve(__dirname, './resources/js'),
        }
    },
    build: {
        target: 'esnext',
    },
    define: {
        'import.meta.env.GOOGLE_MAP_API_KEY': JSON.stringify(env.GOOGLE_MAP_API_KEY)
    }
});

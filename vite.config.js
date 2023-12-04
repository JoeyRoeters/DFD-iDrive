import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import sassGlobImports from 'vite-plugin-sass-glob-import';

const files = [
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/sass/app.scss'
];
import path from 'path';

export default defineConfig({
    root: __dirname,
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
        }
    },
    plugins: [
        laravel({
            input: files,
            refresh: true,
        }),
        sassGlobImports(),
    ],
});

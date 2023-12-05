import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import sassGlobImports from 'vite-plugin-sass-glob-import';
import glob from "glob";
import path from 'path';

let domainFiles = glob.sync('app/UserInterface/Domain/**/Resources/**/*').filter(file => {
    return file.match(/\.(css|js|scss)$/);
});

const files = [
    'resources/css/app.css',
    'resources/js/app.js',
    'resources/sass/app.scss',
    ...domainFiles
];

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


import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import sassGlobImports from 'vite-plugin-sass-glob-import';
import glob from "glob";

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/sass/app.scss', ...glob.sync('app/UserInterface/Domain/**/Resources/**/*.(scss|js)'), ...glob.sync('app/UserInterface/Domain/**/Routes/*.php')],
            refresh: true,
        }),
        sassGlobImports(),
    ],
});



import jQuery from "jquery";
window.$ = jQuery;

import {popper} from "@popperjs/core";

import * as bootstrap from 'bootstrap'
window.bootstrap = bootstrap;
window.popper = popper;

import "sweetalert2";

import * as Sentry from "@sentry/browser";

Sentry.init({
    dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
});

import './bootstrap';

import.meta.glob([
    '../images/**'
]);

// global import for js files in folder
const utils = import.meta.globEager("./*/*.js");
for (const path in utils) {
    window[path.split('/').pop().replace(/\.\w+$/, '')] = utils[path].default;
}

const $nav = $('#nav-bar');

// $(document).on('click', function(event) {
//     // Check if the clicked element is not within #nav-bar
//     if (!$(event.target).closest('#nav-bar').length) {
//         // Remove the class from #nav-bar
//         $('#nav-bar').removeClass('show');
//     }
// });

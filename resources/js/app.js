
import jQuery from "jquery";
window.$ = jQuery;

import {popper} from "@popperjs/core";
window.popper = popper;

import "sweetalert2";

import * as Sentry from "@sentry/browser";

Sentry.init({
    dsn: import.meta.env.VITE_SENTRY_DSN_PUBLIC,
});

import './bootstrap';

// global import for js files in folder
const utils = import.meta.globEager("./*/*.js");
for (const path in utils) {
    window[path.split('/').pop().replace(/\.\w+$/, '')] = utils[path].default;
}

import $ from 'jquery';

const $nav = $('#nav-bar');

$nav.on('mouseenter', function(){
    $(this).addClass('show');
    $('.nav_logo').addClass('show');
});

$nav.on('mouseleave', function(){
    $('.nav_logo').removeClass('show');
    $(this).removeClass('show');
});

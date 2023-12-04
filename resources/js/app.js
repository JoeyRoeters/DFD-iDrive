import jQuery from "jquery";
window.$ = jQuery;

import {popper} from "@popperjs/core";
window.popper = popper;

import Swal from "sweetalert2";

import './bootstrap';

// global import for js files in folder
const utils = import.meta.globEager("./*/*.js");
for (const path in utils) {
    window[path.split('/').pop().replace(/\.\w+$/, '')] = utils[path].default;
}

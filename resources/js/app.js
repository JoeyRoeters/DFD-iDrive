import jQuery from "jquery";
window.$ = jQuery;

import {popper} from "@popperjs/core";
window.popper = popper;

import Swal from "sweetalert2";

import './bootstrap';

// // global import for js files in folder
// const folders = [
//     'utilities',
// ];
// for (const folder of folders) {
//     const dir = `./${folder}/*.js`.toString();
//     const utils = import.meta.glob(dir, { eager: true });
//
//     for (const path in utils) {
//         window[path.split('/').pop().replace(/\.\w+$/, '')] = utils[path].default;
//     }
// }

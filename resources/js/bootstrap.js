/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
//     wsHost: import.meta.env.VITE_PUSHER_HOST ? import.meta.env.VITE_PUSHER_HOST : `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });

document.addEventListener("DOMContentLoaded", function(event) {
    const $toggle = $('#header-toggle');
    const $pageHeader = $('#page-header');
    const $nav = $('#nav-bar');
    const $bodypd = $('#content-page');
    const $headerpd = $('#header');
    const $headerLogo = $('#header-logo');

    $bodypd.css({
        transition: '0.5s'
    });
    $pageHeader.css({
        transition: '0.5s'
    });//#1D3557

    $toggle.on('click', ()=>{
        $nav.toggleClass('show');
        $headerLogo.toggleClass('show');

        if ($nav.hasClass('show')){
            $toggle.removeClass('fa-bars');
            $toggle.addClass('fa-xmark');
        } else {
            $toggle.removeClass('fa-xmark');
            $toggle.addClass('fa-bars');
        }

        $pageHeader.toggleClass('body-pd');
        $bodypd.toggleClass('body-pd');
        $headerpd.toggleClass('body-pd-toggle');
    });

    const linkColor = document.querySelectorAll('.nav_link:not(.no-click)')

    function colorLink(){
        if(linkColor){
            linkColor.forEach(l=> l.classList.remove('active'))
            this.classList.add('active')
        }
    }
    linkColor.forEach(l=> l.addEventListener('click', colorLink))

    $('#single-view-content-pages').find('.nav-link').on('click', function (event) {
        event.preventDefault();
        $(this).addClass('active');

        Tab.getInstance(this).show()
    })
});

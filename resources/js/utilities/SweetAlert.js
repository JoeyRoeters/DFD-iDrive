import swal from 'sweetalert2';

export default class SweetAlert {
    static instance = null;

    constructor() {
        this.init();
    }

    static getInstance() {
        if (this.instance === null) {
            this.instance = new SweetAlert();
        }

        return this.instance;
    }

    init() {
        const swalData = window._swal;
        if (!swalData) {
            const url = new URL(window.location.href);
            const swalParams = url.searchParams.get('swal');
            if (swalParams) {
                swalData = JSON.parse(decodeURIComponent(window.atob(swalParams)));

                history.replaceState && history.replaceState(
                    null, '', location.pathname + location.search.replace(/[\?&]swal=[^&]+/, '').replace(/^&/, '?') + location.hash
                );
            }
        }

        if (swalData) {
            SweetAlert.fire(swalData).then(r => {
                if (swalData.redirect) {
                    window.location.href = swalData.redirect;
                }
            });
        }
    }

    static getDefaultSwalData() {
        return {
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-secondary',
            }
        }
    }

    static fire(data = {}) {
        return swal.fire({
            ...SweetAlert.getDefaultSwalData(),
            ...data
        });
    }
}

window.SweetAlert = SweetAlert.getInstance();

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

    static async fire(data = {}) {
        const popup = await swal.fire({
            ...SweetAlert.getDefaultSwalData(),
            ...data
        });

        if (data.url !== undefined && popup.isConfirmed) {
            window.location.href = data.url;
        }

        return popup;
    }
}

window.SweetAlert = SweetAlert.getInstance();

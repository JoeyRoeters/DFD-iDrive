import 'datatables.net-bs5';
import Column from "./ValueObjects/Column.js";

class DataTable {
    constructor(
        {
            selector = null,
            fetchUrl = null,
            csrf = null,
            columns = [],
            configuration = {}
        }
    ) {
        this.csrf = csrf;
        this.selector = selector;
        this.columns = columns.map(column => new Column(column));
        this.configuration = configuration;
        this.fetchUrl = fetchUrl;

        this.init();
    }

    init() {
        this.table = $(this.selector).DataTable({
            ...this.configuration.tableOptions,
            columns: this.columns.map(column => column.export(this.configuration.configuration.showHeaders)),
            ajax: {
                url: this.fetchUrl,
                headers: {
                    'X-CSRF-TOKEN': this.csrf
                },
                type: "POST"
            },
            serverSide: true,
            deferRender: true,
            bLengthChange: false
        });
    }
}
window.DataTable = DataTable;

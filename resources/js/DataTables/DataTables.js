import 'datatables.net-bs5';
import Column from "./ValueObjects/Column.js";

class DataTable {
    constructor(
        {
            selector = null,
            fetchUrl = null,
            csrf = null,
            totalRecords = 0,
            tableOptions = {},
            columns = [],
            options = {}
        }
    ) {

        this.csrf = csrf;
        this.selector = selector;
        this.tableOptions = tableOptions;
        this.columns = columns.map(column => new Column(column));
        this.options = options;
        this.fetchUrl = fetchUrl;
        this.totalRecords = totalRecords;

        this.init();
    }

    init() {
        this.table = $(this.selector).DataTable({
            ...this.tableOptions,
            columns: this.columns.map(column => column.export()),
            ajax: {
                url: this.fetchUrl,
                headers: {
                    'X-CSRF-TOKEN': this.csrf
                },
                type: "POST"
            },
            serverSide: true,
            deferRender: true
        });
    }
}
window.DataTable = DataTable;

export default class Column {
    constructor(
        {
            label = '',
            renderType = 'text',
        }
    ) {
        this.label = label;
        this.renderType = renderType;
    }

    getLabel() {
        return this.label;
    }

    getRenderType() {
        return this.renderType;
    }

    export(showLabel = true) {
        return {
            title: showLabel ? this.getLabel() : '',
            render: (data, type, row) => this.getRenderCallback(data, type, row),
        };
    }

    getRenderCallback(data, type, row) {
        switch (this.getRenderType()) {
            case 'inline_column_name_with_text':
                return this.renderInlineColumnNameWithText(data, type, row);
            case 'colored_number_0_100':
                return this.renderColoredNumber0_100(data, type, row);
            case 'action_button':
                return this.renderActionButton(data, type, row);
            case 'trip_device_label':
                return this.renderTripDeviceLabel(data, type, row);
            case 'text':
            default:
                return this.renderText(data, type, row);
        }
    }

    renderText(data, type, row) {
        return data;
    }

    renderInlineColumnNameWithText(data, type, row) {
        if (type === 'display') {
            return `<span class="d-block r-type-inline-d">${data}</span> <span class="r-type-inline-l">${this.getLabel()}</span>`;
        }

        return data;
    }

    renderColoredNumber0_100(data, type, row) {
        if (type === 'display') {
            return `<span style="font-size: 1.5rem;" class="text-${data > 50 ? 'success' : 'danger'}">${data}</span>`;
        }
        return data;
    }

    renderActionButton(data, type, row) {
        data = JSON.parse(data);
        if (type === 'display') {
            if (data.buttonEnum === 'arrow') {
                return `<a href="${data.link}" class="btn btn-lg btn-primary float-end"><i class="fa fa-arrow-right"></i></a>`;
            }

            return `<button href="${data.link}" class="btn btn-lg btn-primary float-end"><a class="text-white" href="${data.link}">${data.label}</a></button>`;
        }
        return '';
    }

    renderTripDeviceLabel(data, type, row) {
        if (type === 'display') {
            return `<span class="badge text-bg-primary">${data}</span>`;
            // return `<span class="badge text-black bg-${data === 'active' ? 'success' : 'danger'}">${data}</span>`;
        }

        return data;
    }
}

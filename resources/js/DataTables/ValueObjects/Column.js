import Color from "colorjs.io";

export default class Column {
    constructor(
        {
            label = '',
            renderType = 'text',
            width = null,
        }
    ) {
        this.label = label;
        this.renderType = renderType;
        this.width = width;
    }

    getLabel() {
        return this.label;
    }

    getRenderType() {
        return this.renderType;
    }

    hasWidth() {
        return this.width !== null;
    }

    getWidth() {
        return this.width;
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
            case 'trip_label':
                return this.renderTripLabel(data, type, row);
            case 'multi_action_button':
                return this.renderMultiActionButton(data, type, row);
            case 'text':
            default:
                return this.renderText(data, type, row);
        }
    }

    renderText(data, type, row) {
        return data;
    }

    getInlineWrapper(data) {
        const $wrapper = $('<div>').addClass('d-flex flex-column');

        // data instance of jquery selector
        if ((data instanceof Object && !data.jquery) || typeof data === 'string') {
            data = $('<span>').addClass('d-block r-type-inline-d').text(data);
        }

        $wrapper.append(data);

        $wrapper.append($('<span>').addClass('r-type-inline-l').text(this.getLabel()));

        return $wrapper.prop('outerHTML');
    }

    renderInlineColumnNameWithText(data, type, row) {
        if (type === 'display') {
            return this.getInlineWrapper(data);
        }

        return data;
    }

    renderColoredNumber0_100(data, type, row) {
        if (type === 'display') {
            let text = 'N/A';
            if (data == 0) {
                text = '0';
            } else if (data == 100) {
                text = '10';
            } else if (data !== null && data !== 'N/A') {
                if (data.length > 2) {
                    data = data.replace(/^(.)(.)/, '$1.$2');
                }

                text = data.toString().replace(/^(.)/, '$1.');

                if (!text.match(/\.\d/)) {
                    text += '0';
                }

            }

            const $number = $('<span>').addClass('d-block r-type-inline-d').text(text);

            $number.css({
                'font-size': '1.5rem',
                'color': this.getColorByIntensity(data),
            });

            return this.getInlineWrapper($number);
        }
        return data;
    }

    getColorByIntensity(intensity) {
        if (intensity === null) {
            return 'rgb(0,0,0)';
        }

        let color = new Color("p3", [1, 0, 0]);
        let redgreen = color.range("green", {
            space: "lch", // interpolation space
            outputSpace: "srgb"
        });

        return redgreen(intensity / 100);
    }

    renderActionButton(data, type, row) {
        data = JSON.parse(data);
        if (type === 'display') {
            if (data.buttonEnum === 'arrow') {
                return `<a href="${data.link}" class="btn btn-lg btn-primary float-end"><i class="fa fa-arrow-right"></i></a>`;
            }

            return `<a class="btn btn-lg btn-primary float-end text-white" href="${data.link}">${data.label}</a>`;
        }
        return '';
    }

    renderMultiActionButton(data, type, row) {
        if (type !== 'display') {
            return '';
        }

        data = JSON.parse(data);

        const $wrapper = $('<div>').addClass('d-flex flex-row justify-content-end gap-2 align-items-center');

        data.forEach(item => {
            const $item = this.renderActionButton(item, type, row);

            $wrapper.append($item);
        });

        return $wrapper.prop('outerHTML');
    }

    renderTripLabel(data, type, row) {
        data = JSON.parse(data);

        this.label = "Device: " + data.deviceName;

        if (type === 'display') {
            const $wrapper = $('<div>').addClass('d-flex flex-row justify-content-start align-items-center');

            $wrapper.css({
                'column-gap': '1rem',
            });

            const $badgeWrapper = $('<div>').addClass('dt-badge-number-wrapper');
            const $badge = $('<span>').addClass('number').text("#" + data.tripNumber);

            $badgeWrapper.append($badge);
            $wrapper.append($badgeWrapper);

            const $numberWrapper = this.getInlineWrapper("Trip #" + data.tripNumber);

            $wrapper.append($numberWrapper);

            return $wrapper.prop('outerHTML');
        }

        return data;
    }
}

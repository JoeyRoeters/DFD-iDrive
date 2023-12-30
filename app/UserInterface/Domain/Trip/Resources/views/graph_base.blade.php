<div id="chartdiv"></div>

<script>

    function convertDataArray(inputData) {
        var data = [];
        for (var i = 0; i < inputData.length; i++) {
            // Controleer of de tijdreeks gedefinieerd is
            if (inputData[i].timestamp) {
                var dateString = inputData[i].timestamp;

                // Extraheren van het gedeelte na de spatie
                var timeString = dateString.split(" ")[1];

                // Creëer een nieuwe datum met een standaarddatum en de geëxtraheerde tijd
                var combinedDateString = "2023-01-01 " + timeString;
                var time = new Date(combinedDateString).getTime();

                var speed = inputData[i].speed;
                data.push({time: time, speed: speed});
                console.log(time, speed)
            } else {
                console.error("time is undefined for input data at index", i, inputData[i]);
            }
        }
        return data;
    }



    var root = am5.Root.new("chartdiv");
    root.setThemes([am5themes_Animated.new(root)]);

    var chart = root.container.children.push(am5xy.XYChart.new(root, {
        panX: true,
        panY: false,
        wheelX: "{{ $zoomEnabled ? 'panX' : 'none' }}",
        wheelY: "{{ $zoomEnabled ? 'zoomX' : 'none' }}",
        paddingLeft: 0 // Of een andere standaardwaarde
    }));

    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
    cursor.lineY.set("visible", false);

    var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
        baseInterval: {
            timeUnit: "millisecond", // Of een andere waarde gebaseerd op $xAxisFormat
            count: 1
        },
        renderer: am5xy.AxisRendererX.new(root, {}),
        tooltip: am5.Tooltip.new(root, {})
    }));

    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {})
    }));

    var series = chart.series.push(am5xy.LineSeries.new(root, {
        name: "{{ $graphName }}",
        xAxis: xAxis,
        yAxis: yAxis,
        valueYField: "speed",
        valueXField: "time",
        tooltip: am5.Tooltip.new(root, {
            labelText: "{{ $tooltipFormat }}"
        })
    }));

    var scrollbar = am5xy.XYChartScrollbar.new(root, {
        orientation: "horizontal", // Of een andere standaardwaarde
        height: 50 // Of een andere standaardwaarde
    });
    chart.set("scrollbarX", scrollbar);

    var sbxAxis = scrollbar.chart.xAxes.push(am5xy.DateAxis.new(root, {
        baseInterval: {timeUnit: "millisecond", count: 1},
        renderer: am5xy.AxisRendererX.new(root, {
            minorGridEnabled: true,
            opposite: false,
            strokeOpacity: 0
        })
    }));

    var sbyAxis = scrollbar.chart.yAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {})
    }));

    var sbseries = scrollbar.chart.series.push(am5xy.LineSeries.new(root, {
        xAxis: sbxAxis,
        yAxis: sbyAxis,
        valueYField: "speed",
        valueXField: "time"
    }));

    var data = convertDataArray(@json($graphData));
    console.log(data)
    series.data.setAll(data);
    sbseries.data.setAll(data);

    series.appear(1000);
    chart.appear(1000, 100);

</script>


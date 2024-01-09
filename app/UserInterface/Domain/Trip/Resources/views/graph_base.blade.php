<div id="chartdiv"></div>

<script>

    function convertDataArray(inputData) {
        var data = [];

        // Buitenste lus om door de hoofdarray te gaan
        for (var j = 0; j < inputData.length; j++) {
            var currentArray = inputData[j];
            var convertedData = [];

            // Binnenste lus om door elke subarray te gaan
            for (var i = 0; i < currentArray.length; i++) {
                var currentItem = currentArray[i];

                if (currentItem.timestamp) {
                    var dateString = currentItem.timestamp;
                    var time = new Date(dateString).getTime();

                    if (currentItem.speed !== undefined) {
                        var speed = currentItem.speed;
                        convertedData.push({ time: time, speed: speed });
                    } else {
                        console.error("Speed is undefined for input data at index", i, currentItem);
                    }
                } else {
                    console.error("Timestamp is undefined for input data at index", i, currentItem);
                }
            }

            // Voeg de geconverteerde data toe aan de hoofddata-array
            data.push(convertedData);
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
        paddingLeft: 0 // Or another default value
    }));

    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
    cursor.lineY.set("visible", false);

    var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
        baseInterval: {
            timeUnit: "millisecond", // Or another value based on $xAxisFormat
            count: 1
        },
        renderer: am5xy.AxisRendererX.new(root, {}),
        tooltip: am5.Tooltip.new(root, {})
    }));

    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {})
    }));

    // Process the data
    var graphData = convertDataArray(@json($graphData));
    var data1 = graphData[0];
    var data2 = graphData.length > 1 ? graphData[1] : [];

    let colors = @json($colors);


    var series1 = chart.series.push(am5xy.LineSeries.new(root, {
        name: "{{ $graphName }}",
        xAxis: xAxis,
        yAxis: yAxis,
        stroke: am5.color(colors[0]),
        valueYField: "speed",
        valueXField: "time",
        tooltip: am5.Tooltip.new(root, {
            labelText: "{{ $tooltipFormat }}"
        })
    }));
    series1.data.setAll(data1);

    if (data2.length > 0) {
        var series2 = chart.series.push(am5xy.LineSeries.new(root, {
            name: "{{ $graphName }}", // Update this if you have a specific name for the second dataset
            xAxis: xAxis,
            yAxis: yAxis,
            stroke: am5.color(colors[1]),
            valueYField: "speed",
            valueXField: "time",
            tooltip: am5.Tooltip.new(root, {
                labelText: "{{ $tooltipFormat }}" // Update if different for the second dataset
            })
        }));
        series2.data.setAll(data2);
    }

    var scrollbar = am5xy.XYChartScrollbar.new(root, {
        orientation: "horizontal",
        height: 50
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

    var sbseries1 = scrollbar.chart.series.push(am5xy.LineSeries.new(root, {
        xAxis: sbxAxis,
        yAxis: sbyAxis,
        stroke: am5.color(colors[0]),
        valueYField: "speed",
        valueXField: "time"
    }));
    sbseries1.data.setAll(data1);

    if (data2.length > 0) {
        var sbseries2 = scrollbar.chart.series.push(am5xy.LineSeries.new(root, {
            xAxis: sbxAxis,
            yAxis: sbyAxis,
            stroke: am5.color(colors[1]),
            valueYField: "speed",
            valueXField: "time"
        }));
        sbseries2.data.setAll(data2);
    }

    series1.appear(1000);
    if (data2.length > 0) {
        series2.appear(1000);
    }
    chart.appear(1000, 100);

</script>


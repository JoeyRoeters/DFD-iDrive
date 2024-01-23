<div id="chartdiv"></div>

<script>

    function convertDataArray(inputData, xyFieldValues) {
        var data = [];

        // Controleer of inputData een 2D-array of 1D-array is
        if (Array.isArray(inputData[0])) {
            // 2D-array, verwerk elke subarray
            for (var j = 0; j < inputData.length; j++) {
                data.push(convertSingleArray(inputData[j], xyFieldValues[j]));
            }
        } else {
            // 1D-array, verwerk als enkele array
            data.push(convertSingleArray(inputData, xyFieldValues[0]));
        }

        return data;
    }

    function convertSingleArray(currentArray, xyFieldValue) {
        var convertedData = [];

        var xAxisLabel = xyFieldValue['x'];
        var yAxisLabel = xyFieldValue['y'];

        for (var i = 0; i < currentArray.length; i++) {
            var currentItem = currentArray[i];

            if (currentItem.timestamp) {
                var dateString = currentItem.timestamp;
                var time = new Date(dateString).getTime();

                if (currentItem[yAxisLabel] !== undefined) {
                    var yValue = currentItem[yAxisLabel];
                    convertedData.push({timestamp: time, [yAxisLabel]: yValue});
                } else {
                    console.error(yAxisLabel + " is undefined for input data at index", i, currentItem);
                }
            } else {
                console.error("Timestamp is undefined for input data at index", i, currentItem);
            }
        }

        return convertedData;
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

    var tooltip = @json($tooltipFormat);

    var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
    cursor.lineY.set("visible", false);

    var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
        baseInterval: {
            timeUnit: "{{ $timeUnitInterval }}",
            count: 1
        },
        renderer: am5xy.AxisRendererX.new(root, {}),
        tooltip: am5.Tooltip.new(root, {})
    }));

    var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
        renderer: am5xy.AxisRendererY.new(root, {})
    }));

    var xyFieldValues = @json($axisLabels)


    // Process the data
    var graphData = convertDataArray(@json($graphData), xyFieldValues);
    var data1 = graphData[0];
    var data2 = graphData.length > 1 ? graphData[1] : [];
    var data3 = convertSingleArray(@json($speedLimit), @json([
                'x' => 'timestamp',
                'y' => 'speed_limit',
            ]))

    var colors = @json($colors);


    var series1 = chart.series.push(am5xy.LineSeries.new(root, {
        name: "{{ $graphName }}",
        xAxis: xAxis,
        yAxis: yAxis,
        stroke: am5.color(colors[0]),
        valueYField: xyFieldValues[0]["y"],
        valueXField: xyFieldValues[0]["x"],
        tooltip: am5.Tooltip.new(root, {
            labelText: tooltip[0]
        })
    }));
    series1.data.setAll(data1);

    if (data2.length > 0) {
        var series2 = chart.series.push(am5xy.LineSeries.new(root, {
            name: "{{ $graphName }}", // Update this if you have a specific name for the second dataset
            xAxis: xAxis,
            yAxis: yAxis,
            stroke: am5.color(colors[1]),
            valueYField: xyFieldValues[1]["y"],
            valueXField: xyFieldValues[1]["x"],
            tooltip: am5.Tooltip.new(root, {
                labelText: tooltip[1] // Update if different for the second dataset
            })
        }));
        series2.data.setAll(data2);
    }



    if (data3.length > 0) {
        var series3 = chart.series.push(am5xy.LineSeries.new(root, {
            name: "{{ $graphName }}", // Update this if you have a specific name for the second dataset
            xAxis: xAxis,
            yAxis: yAxis,
            stroke: "#000000",
            valueYField: 'speed_limit',
            valueXField: 'timestamp',
            tooltip: am5.Tooltip.new(root, {
                labelText: "{speed_limit} km/h" // Update if different for the second dataset
            })
        }));
        series3.data.setAll(data3);
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
        valueYField: xyFieldValues[0]["y"],
        valueXField: xyFieldValues[0]["x"],
    }));
    sbseries1.data.setAll(data1);

    if (data2.length > 0) {
        var sbseries2 = scrollbar.chart.series.push(am5xy.LineSeries.new(root, {
            xAxis: sbxAxis,
            yAxis: sbyAxis,
            stroke: am5.color(colors[1]),
            valueYField: xyFieldValues[1]["y"],
            valueXField: xyFieldValues[1]["x"],
        }));
        sbseries2.data.setAll(data2);
    }


    var dotData = @json($dotData);



    var dotDataConverted = convertSingleArray(dotData, xyFieldValues[2]);
    var dotDataMap = {};
    dotDataConverted.forEach(function(dotItem) {
        dotDataMap[dotItem[xyFieldValues[2]["x"]]] = dotItem.type;
    });

    series1.bullets.push(function(root, series, dataItem) {
        var type = dotDataMap[dataItem.dataContext[xyFieldValues[0]["x"]]];
        if (type) {
            return am5.Bullet.new(root, {
                sprite: am5.Circle.new(root, {
                    radius: 5,
                    fill: am5.color("#ff0000"),
                    tooltipText: type
                })
            });
        }
    });



    series1.appear(1000);
    if (data2.length > 0) {
        series2.appear(1000);
    }
    series3.appear(1000);
    chart.appear(1000, 100);

</script>


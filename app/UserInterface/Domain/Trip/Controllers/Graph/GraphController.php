<?php

namespace App\UserInterface\Domain\Trip\Controllers\Graph;

use App\Helpers\Graph\Enums\AxisFormat;
use App\Helpers\Graph\Enums\GraphType;
use App\Helpers\Graph\Enums\ValueType;
use App\Infrastructure\Laravel\Controller;

class GraphController extends Controller
{

    private string $graphName = '';
    private array $graphData = [];
    private string $graphXName = '';
    private string $graphYName = '';
    private GraphType $graphType;
    private ValueType $xValueType;
    private ValueType $yValueType;
    private AxisFormat $xAxisFormat;
    private AxisFormat $yAxisFormat;
    private string $tooltipFormat = '';
    private array $colors = [];
    private bool $legendDisplay = false;
    private array $responsiveOptions = [];
    private array $axisLabels = [];
    private bool $dataLabelsEnabled = false;
    private bool $zoomEnabled = false;


    /**
     * @param $name
     */
    public function __construct($name)
    {
        $this->name = $name;

        $this->graphType = GraphType::LINE;
        $this->xValueType = ValueType::NUMBER;
        $this->yValueType = ValueType::NUMBER;
        $this->xAxisFormat = AxisFormat::LINEAR;
        $this->yAxisFormat = AxisFormat::LINEAR;

        return $this;
    }


    public function make(){
        return view('graph_base', $this->toArray());
    }



    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): GraphController
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGraphName()
    {
        return $this->graphName;
    }

    /**
     * @param mixed $graphName
     */
    public function setGraphName($graphName): GraphController
    {
        $this->graphName = $graphName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGraphData()
    {
        return $this->graphData;
    }

    /**
     * @param mixed $graphData
     */
    public function setGraphData($graphData): GraphController
    {
        $this->graphData = $graphData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGraphXName()
    {
        return $this->graphXName;
    }

    /**
     * @param mixed $graphXName
     */
    public function setGraphXName($graphXName): GraphController
    {
        $this->graphXName = $graphXName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGraphYName()
    {
        return $this->graphYName;
    }

    /**
     * @param mixed $graphYName
     */
    public function setGraphYName($graphYName): GraphController
    {
        $this->graphYName = $graphYName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGraphType()
    {
        return $this->graphType;
    }

    /**
     * @param mixed $graphType
     */
    public function setGraphType(GraphType $graphType): GraphController
    {
        $this->graphType = $graphType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getXValueType()
    {
        return $this->xValueType;
    }

    /**
     * @param mixed $xValueType
     */
    public function setXValueType(ValueType $xValueType): GraphController
    {
        $this->xValueType = $xValueType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getYValueType()
    {
        return $this->yValueType;
    }

    /**
     * @param mixed $yValueType
     */
    public function setYValueType(ValueType $yValueType): GraphController
    {
        $this->yValueType = $yValueType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getXAxisFormat()
    {
        return $this->xAxisFormat;
    }

    /**
     * @param mixed $xAxisFormat
     */
    public function setXAxisFormat(AxisFormat $xAxisFormat): GraphController
    {
        $this->xAxisFormat = $xAxisFormat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getYAxisFormat()
    {
        return $this->yAxisFormat;
    }

    /**
     * @param mixed $yAxisFormat
     */
    public function setYAxisFormat(AxisFormat $yAxisFormat): GraphController
    {
        $this->yAxisFormat = $yAxisFormat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTooltipFormat()
    {
        return $this->tooltipFormat;
    }

    /**
     * @param mixed $tooltipFormat
     */
    public function setTooltipFormat($tooltipFormat): GraphController
    {
        $this->tooltipFormat = $tooltipFormat;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * @param mixed $colors
     */
    public function setColors($colors): GraphController
    {
        $this->colors = $colors;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLegendDisplay()
    {
        return $this->legendDisplay;
    }

    /**
     * @param mixed $legendDisplay
     */
    public function setLegendDisplay($legendDisplay): GraphController
    {
        $this->legendDisplay = $legendDisplay;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResponsiveOptions()
    {
        return $this->responsiveOptions;
    }

    /**
     * @param mixed $responsiveOptions
     */
    public function setResponsiveOptions($responsiveOptions): GraphController
    {
        $this->responsiveOptions = $responsiveOptions;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAxisLabels()
    {
        return $this->axisLabels;
    }

    /**
     * @param mixed $axisLabels
     */
    public function setAxisLabels($axisLabels): GraphController
    {
        $this->axisLabels = $axisLabels;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDataLabelsEnabled()
    {
        return $this->dataLabelsEnabled;
    }

    /**
     * @param mixed $dataLabelsEnabled
     */
    public function setDataLabelsEnabled($dataLabelsEnabled): GraphController
    {
        $this->dataLabelsEnabled = $dataLabelsEnabled;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getZoomEnabled()
    {
        return $this->zoomEnabled;
    }

    /**
     * @param mixed $zoomEnabled
     */
    public function setZoomEnabled($zoomEnabled): GraphController
    {
        $this->zoomEnabled = $zoomEnabled;
        return $this;
    }

    private function toArray(){
        return [
            'graphName' => $this->graphName,
            'graphData' => $this->graphData,
            'graphXName' => $this->graphXName,
            'graphYName' => $this->graphYName,
            'graphType' => $this->graphType,
            'xValueType' => $this->xValueType,
            'yValueType' => $this->yValueType,
            'xAxisFormat' => $this->xAxisFormat,
            'yAxisFormat' => $this->yAxisFormat,
            'tooltipFormat' => $this->tooltipFormat,
            'colors' => $this->colors,
            'legendDisplay' => $this->legendDisplay,
            'responsiveOptions' => $this->responsiveOptions,
            'axisLabels' => $this->axisLabels,
            'dataLabelsEnabled' => $this->dataLabelsEnabled,
            'zoomEnabled' => $this->zoomEnabled,
        ];
    }







}

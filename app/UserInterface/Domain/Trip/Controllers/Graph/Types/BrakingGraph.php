<?php

namespace App\UserInterface\Domain\Trip\Controllers\Graph\Types;

use App\Domain\Trip\Model\TripData;
use App\Helpers\Graph\Enums\AxisFormat;
use App\Helpers\Graph\Enums\GraphType;
use App\Helpers\Graph\Enums\ValueType;
use App\UserInterface\Domain\Trip\Controllers\Graph\GraphController;
use Illuminate\Contracts\View\View;

class BrakingGraph extends GraphController
{
    public function __construct()
    {
        parent::__construct('braking_graph');
        $this->setGraphName('Speed and Braking')
            ->setGraphXName('Time')
            ->setGraphYName('Speed / Braking')
            ->setGraphType(GraphType::LINE)
            ->setXValueType(ValueType::NUMBER)
            ->setYValueType(ValueType::NUMBER)
            ->setXAxisFormat(AxisFormat::LINEAR)
            ->setYAxisFormat(AxisFormat::LINEAR)
            ->setColors(['#1e88e5', '#e53935']) // Twee kleuren voor twee datasets
            ->setLegendDisplay(true)
            ->setResponsiveOptions([
                'maintainAspectRatio' => false,
                'legend' => [
                    'display' => true,
                ],
                'scales' => [
                    'xAxes' => [
                        [
                            'display' => true,
                            'scaleLabel' => [
                                'display' => true,
                                'labelString' => 'Time',
                            ],
                        ],
                    ],
                    'yAxes' => [
                        [
                            'display' => true,
                            'scaleLabel' => [
                                'display' => true,
                                'labelString' => 'Speed',
                            ],
                            'position' => 'left',
                        ],
                        [
                            'display' => true,
                            'scaleLabel' => [
                                'display' => true,
                                'labelString' => 'Braking',
                            ],
                            'position' => 'right',
                            'gridLines' => [
                                'drawOnChartArea' => false,
                            ],
                        ],
                    ],
                ],
            ])
            ->setAxisLabels([
                'x' => 'Time',
                'y' => 'Speed',
            ])
            ->setDataLabelsEnabled(false)
            ->setZoomEnabled(true)
            ->setGraphData([]);
    }


    public function render(): View
    {
        return $this->make();
    }

}

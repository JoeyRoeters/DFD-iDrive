<?php

namespace App\UserInterface\Domain\Trip\Controllers\Graph\Types;

use App\Domain\Trip\Model\TripData;
use App\Helpers\Graph\Enums\AxisFormat;
use App\Helpers\Graph\Enums\GraphType;
use App\Helpers\Graph\Enums\ValueType;
use App\UserInterface\Domain\Trip\Controllers\Graph\GraphController;
use Illuminate\Contracts\View\View;

class SpeedGraph extends GraphController
{
    public function __construct()
    {
        parent::__construct('speed_graph');
        $this->setGraphName('Speed')
            ->setGraphXName('Time')
            ->setGraphYName('Speed')
            ->setGraphType(GraphType::LINE)
            ->setXValueType(ValueType::NUMBER)
            ->setYValueType(ValueType::NUMBER)
            ->setXAxisFormat(AxisFormat::LINEAR)
            ->setYAxisFormat(AxisFormat::LINEAR)
            ->setTooltipFormat('{x} km/h')
            ->setColors(['#1e88e5'])
            ->setLegendDisplay(false)
            ->setResponsiveOptions([
                'maintainAspectRatio' => false,
                'legend' => [
                    'display' => false,
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
            ->setGraphData(TripData::select('speed', 'time')->get()->toArray());
    }

    public function render(): View
    {
        return $this->make();
    }

}

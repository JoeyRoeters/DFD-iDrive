<?php

namespace App\UserInterface\Domain\Trip\Controllers\Graph\Types;

use App\Domain\Trip\Model\TripData;
use App\Helpers\Graph\Enums\AxisFormat;
use App\Helpers\Graph\Enums\GraphType;
use App\Helpers\Graph\Enums\ValueType;
use App\UserInterface\Domain\Trip\Controllers\Graph\GraphController;
use Illuminate\Contracts\View\View;

class WarningGraph extends GraphController
{
    public function __construct()
    {
        parent::__construct('warning_graph');
        $this->setGraphName('Speed and Braking')
            ->setGraphXName('Time')
            ->setGraphYName('Speed / Braking')
            ->setGraphType(GraphType::LINE)
            ->setXValueType(ValueType::NUMBER)
            ->setYValueType(ValueType::NUMBER)
            ->setXAxisFormat(AxisFormat::LINEAR)
            ->setYAxisFormat(AxisFormat::LINEAR)
            ->setTooltipFormat([['{speed} km/h'], ['{brakepower} %']])
            ->setColors(['#1e88e5', '#e53935']) // Twee kleuren voor twee datasets
            ->setLegendDisplay(true)
            ->setAxisLabels([
                [
                    'x' => 'timestamp',
                    'y' => 'speed',
                ],
                [
                    'x' => 'timestamp',
                    'y' => 'brakepower',
                ],
                [
                'x' => 'timestamp',
                'y' => 'type',
            ]
            ])
            ->setDataLabelsEnabled(false)
            ->setZoomEnabled(true)
            ->setTimeUnitInterval("millisecond")
            ->setGraphData([])
            ->setDotData([]);
    }


    public function render(): View
    {
        return $this->make();
    }

}

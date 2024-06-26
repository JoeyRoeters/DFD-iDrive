<?php

namespace App\UserInterface\Domain\Trip\Controllers;

use App\Domain\Shared\Interface\BreadCrumbInterface;
use App\Domain\Shared\ValueObject\BreadCrumbValueObject;
use App\Domain\Shared\ValueObject\RouteValueObject;
use App\Domain\Trip\Helper\Parsers\TripProfileParser;
use App\Domain\Trip\Jobs\PostTripJob;
use App\Domain\Trip\Model\Trip;
use App\Domain\Trip\Model\TripData;
use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use App\UserInterface\Domain\Trip\Controllers\Graph\Types\BrakingGraph;
use App\UserInterface\Domain\Trip\Controllers\Graph\Types\SpeedGraph;
use Illuminate\Http\Request;

class TripShowController extends AbstractViewController implements BreadCrumbInterface
{
    protected Trip $trip;

    /**
     * @inheritdoc
     */
    protected function view(): string
    {
        return 'trip_show';
    }

    public function loadData(Request $request): void
    {
        parent::loadData($request);
        $id = $request->route('id');

        $this->trip = Trip::find($id)
            ->where('_id', $id)
            ->where('user_id', $request->user()->id)
            ->first();
    }


    protected function pageHeader(): PageHeaderValueOject
    {
        return new PageHeaderValueOject(
            title: 'Trip #' . $this->trip->getNumberFormatted()
        );
    }

    protected function appendViewData(Request $request): array
    {
        $psot = new PostTripJob($this->trip);
        $psot->handle($this->trip);
        return [
            'trip' => $this->trip,
            'profiles' => array_map(fn ($parser) => $parser->getProfile(), TripProfileParser::getParsers($this->trip)),
        ];
    }

    public function getBreadCrumb(Request $request): BreadCrumbValueObject
    {
        return new BreadCrumbValueObject(
            title: 'Trip #' . $this->trip->getNumberFormatted(),
            route: new RouteValueObject('trip.show.overview', ['id' => $this->trip->id]),
            parentClass: Main::class,
        );
    }


    public function getGraph(Request $request)
    {
        $dataType = $request->input('graph');


        switch ($dataType) {
            case 'speed':
                $SpeedGraph = new SpeedGraph();

                $graphData = TripData::where('trip_id', $request->route('id'))
                    ->orderBy('timestamp', 'asc')
                    ->get(['speed', 'timestamp', 'trip_id'])
                    ->toArray();


                $SpeedGraph->setGraphData($this->formatTimeStamp($graphData));
                return $SpeedGraph->render();

            case "speed_braking":
                $speed_brakeGraph = new BrakingGraph();

                $dbData = TripData::where('trip_id', $request->route('id'))
                    ->orderBy('timestamp', 'asc')
                    ->get(['speed', 'timestamp', "accelero"])
                    ->toArray();

                $speed_brakeGraph->setGraphData([$this->formatTimeStamp($dbData), $this->calculateBrakePower($dbData)]);

                return $speed_brakeGraph->render();

            default:
                $data = [];
                return $data;
        }
    }

    private function formatTimeStamp(array $data)
    {
        $formattedData = [];
        foreach ($data as $record) {
            $formattedData[] = [
                'speed' => $record['speed'],
                'timestamp' => strtotime($record['timestamp'])
            ];
        }
        return $formattedData;

    }


    private function calculateBrakePower($data)
    {
        $remKrachtData = [];

        foreach ($data as $record) {
            if (isset($record['accelero']) && is_array($record['accelero'])) {
                $x = $record['accelero'][0];
                $y = $record['accelero'][1];
                $z = $record['accelero'][2];
                $magnitude = sqrt($x * $x + $y * $y + $z * $z);

                $drempelwaarde = 10;

                $remkracht = $magnitude > $drempelwaarde ? $magnitude : 0;

                $remKrachtData[] = [
                    'timestamp' => strtotime($record['timestamp']),
                    'brakepower' => $remkracht
                ];
            }
        }

        return $remKrachtData;
    }
}

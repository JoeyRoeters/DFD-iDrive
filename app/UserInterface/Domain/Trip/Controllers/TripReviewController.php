<?php

namespace App\UserInterface\Domain\Trip\Controllers;

use App\Domain\Trip\Model\TripData;
use App\Domain\Trip\Model\TripEvent;
use App\Infrastructure\Laravel\Controller;
use App\UserInterface\Domain\Trip\Controllers\Graph\Types\BrakingGraph;
use App\UserInterface\Domain\Trip\Controllers\Graph\Types\SpeedGraph;
use App\UserInterface\Domain\Trip\Controllers\Graph\Types\WarningGraph;
use Illuminate\Http\Request;

class TripReviewController extends Controller
{
    public function getGraph(Request $request)
    {
        $dataType = $request->input('graph');


        switch ($dataType) {
            case 'speed':
                $SpeedGraph = new SpeedGraph();

                $graphData = TripData::where('trip_id', $request->input('id'))
                    ->orderBy('timestamp', 'asc')
                    ->get(['speed', 'timestamp', 'trip_id'])
                    ->toArray();

                $SpeedGraph->setGraphData($this->formatTimeStamp($graphData));
                return $SpeedGraph->render();

            case "speed_braking":
                $speed_brakeGraph = new BrakingGraph();

                $dbData = TripData::where('trip_id', $request->input('id'))
                    ->orderBy('timestamp', 'asc')
                    ->get(['speed', 'timestamp', "accelero"])
                    ->toArray();

                $speed_brakeGraph->setGraphData([$this->formatTimeStamp($dbData), $this->calculateBrakePower($dbData)]);

                return $speed_brakeGraph->render();

            case "warnings":
                $warningGraph = new WarningGraph();

                $trip_events = TripEvent::whereTripId($request->input('id'))->get([])->toArray();
                $trip_events = array_map(function ($event) {
                    $event['timestamp'] = strtotime($event['timestamp']);
                    return $event;
                }, $trip_events);

                $dbData = TripData::where('trip_id', $request->input('id'))
                    ->orderBy('timestamp', 'asc')
                    ->get(['speed', 'timestamp', "accelero"])
                    ->toArray();

                $warningGraph->setGraphData([$this->formatTimeStamp($dbData), $this->calculateBrakePower($dbData)]);
                $warningGraph->setDotData($trip_events);


                return $warningGraph->render();



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

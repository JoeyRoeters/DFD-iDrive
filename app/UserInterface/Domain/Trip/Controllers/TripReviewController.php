<?php

namespace App\UserInterface\Domain\Trip\Controllers;

use App\Domain\Device\Model\Device;
use App\Domain\Trip\Model\Trip;
use App\Domain\Trip\Model\TripData;
use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use App\UserInterface\Domain\Trip\Controllers\Graph\Types\SpeedGraph;
use DateTime;
use Illuminate\Http\Request;

class TripReviewController extends AbstractViewController
{
    protected Trip $trip;


    /**
     * @inheritdoc
     */
    protected function view(): string
    {
        return 'trip_review';
    }

    protected function loadData(Request $request): void
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
            title: 'Trip',
            subtitle: "Review",
            buttons: [
                ButtonValueObject::make('Go back', 'trip.main', 'fa-solid fa-backward'),
                ButtonValueObject::make(
                    'Case review',
                    'trip.show.review',
                    'fa-solid fa-list-check',
                    "secondary",
                    routeParameters: ['id' => $this->trip->id]
                ),
                ButtonValueObject::make(
                    'Overview',
                    'trip.show.overview',
                    'fa-solid fa-file',
                    "success",
                    routeParameters: ['id' => $this->trip->id]
                ),
            ]
        );
    }

    protected function appendViewData(Request $request): array
    {
        return [
            'trip' => $this->trip,
        ];
    }



    public function getGraph(Request $request)
    {
        $dataType = $request->input('graph');


        switch ($dataType) {
            case 'speed':
                $SpeedGraph = new SpeedGraph();
                return $SpeedGraph->render();

            default:
                $data = [];
        }
    }

    public function getGraphData(Request $request)
    {
        $dataType = $request->input('dataType');


        switch ($dataType) {
            case 'speed':
                $data = $this->getSpeedGraph();
                break;

            default:
                $data = [];
        }

        return response()->json($data);
    }

}

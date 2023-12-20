<?php

namespace App\UserInterface\Domain\Trip\Controllers;

use App\Domain\Device\Model\Device;
use App\Domain\Trip\Model\Trip;
use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use Illuminate\Http\Request;

class TripController extends AbstractViewController
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
            subtitle: "Details",
            buttons: [
                ButtonValueObject::make('Go back', 'trip.main', 'fa-solid fa-backward'),
                ButtonValueObject::make('Case review', 'trip.main', 'fa-solid fa-list-check', "secondary"),
                ButtonValueObject::make('Overview', 'trip.main', 'fa-solid fa-file', color: "success"),

            ]
        );
    }

    protected function appendViewData(Request $request): array
    {
        return [
            'trip' => $this->trip,
        ];
    }

}

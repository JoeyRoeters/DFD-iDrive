<?php

namespace App\UserInterface\Domain\Trip\Controllers;

use App\Domain\Device\Model\Device;
use App\Domain\Shared\Interface\BreadCrumbInterface;
use App\Domain\Shared\ValueObject\BreadCrumbValueObject;
use App\Domain\Shared\ValueObject\RouteValueObject;
use App\Domain\Trip\Model\Trip;
use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use Illuminate\Http\Request;

class TripReviewController extends AbstractViewController implements BreadCrumbInterface
{
    protected Trip $trip;

    /**
     * @inheritdoc
     */
    protected function view(): string
    {
        return 'trip_review';
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
            title: 'Trip #' . $this->trip->number,
            buttons: [
                new ButtonValueObject(
                    label: 'Overview',
                    route: new RouteValueObject('trip.show.overview', ['id' => $this->trip->id]),
                    icon: 'fa-solid fa-file',
                    color: 'success',
                )
            ]
        );
    }

    protected function appendViewData(Request $request): array
    {
        return [
            'trip' => $this->trip,
        ];
    }

    public function getBreadCrumb(Request $request): BreadCrumbValueObject
    {
        return new BreadCrumbValueObject(
            title: 'Trip #' . $this->trip->number,
            route: new RouteValueObject('trip.show.review', ['id' => $this->trip->id]),
            parentClass: Main::class,
        );
    }
}

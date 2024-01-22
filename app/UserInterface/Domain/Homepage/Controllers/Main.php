<?php

namespace App\UserInterface\Domain\Homepage\Controllers;

use App\Domain\Device\Model\Device;
use App\Domain\Shared\Interface\BreadCrumbInterface;
use App\Domain\Shared\ValueObject\BreadCrumbValueObject;
use App\Domain\Shared\ValueObject\RouteValueObject;
use App\Domain\Trip\Jobs\PostTripJob;
use App\Domain\Trip\Model\Trip;
use App\Domain\Trip\Model\TripEvent;
use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Main extends AbstractViewController implements BreadCrumbInterface
{
    /**
     * @inheritdoc
     */
    protected function view(): string
    {
        return 'homepage';
    }

    /**
     * @inheritdoc
     */
    protected function pageHeader(): PageHeaderValueOject
    {
        return new PageHeaderValueOject(
            title: 'Homepage',
            buttons: []
        );
    }

    /**
     * @inheritdoc
     */


    public function getBreadCrumb(Request $request): BreadCrumbValueObject
    {
        return new BreadCrumbValueObject(
            title: 'Dashboard',
            route: new RouteValueObject('homepage')
        );
    }

    public function get_stats()
    {

        $data['weekly'] = $this->get_weekly_review();

        return response()->json(['stats' => $data]);
    }

    public function get_weekly_review()
    {
        $allSpeeds = [];
        $trip = Trip::whereUserId(Auth::id())->get();
        foreach ($trip as $t) {
            $allSpeeds[] = $t->data()->get()->avg('speed');
        }
        $sumspeed = array_sum($allSpeeds);
        $avgspeed = $sumspeed / count($allSpeeds);
        $rounded = round($avgspeed);
        $data['avg_speed'] = $rounded;
        return $data;
    }

    public function get_recent_trips()
    {
    }

    protected function appendViewData(Request $request): array
    {
        $data['device'] = Device::whereUserId(Auth::id())->orderBy('created_at', 'desc')->first();
        return $data;
    }
}

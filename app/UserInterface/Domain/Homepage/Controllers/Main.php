<?php

namespace App\UserInterface\Domain\Homepage\Controllers;

use App\Domain\Device\Model\Device;
use App\Domain\Shared\Interface\BreadCrumbInterface;
use App\Domain\Shared\ValueObject\BreadCrumbValueObject;
use App\Domain\Shared\ValueObject\RouteValueObject;
use App\Domain\Trip\Jobs\PostTripJob;
use App\Domain\Trip\Model\Trip;
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
    protected function appendViewData(Request $request): array
    {
        $data['recent_device'] = $this->get_recent_device();

//        dd($data);

        return [];
    }

    public function getBreadCrumb(Request $request): BreadCrumbValueObject
    {
        return new BreadCrumbValueObject(
            title: 'Dashboard',
            route: new RouteValueObject('homepage')
        );
    }


    public function get_recent_device(){


        $result = Device::whereUserId(Auth::id())->orderBy('created_at', 'desc')->first();

        Trip::whereDeviceId($result->id);

        return Trip::whereUserId(Auth::id())->orderBy('created_at', 'desc')->first();
    }


    public function get_weekly_review(){

    }

    public function get_recent_trips(){

    }
}

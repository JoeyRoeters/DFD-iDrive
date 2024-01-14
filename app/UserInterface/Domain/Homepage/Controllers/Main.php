<?php

namespace App\UserInterface\Domain\Homepage\Controllers;

use App\Domain\Shared\Interface\BreadCrumbInterface;
use App\Domain\Shared\ValueObject\BreadCrumbValueObject;
use App\Domain\Shared\ValueObject\RouteValueObject;
use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use Illuminate\Http\Request;

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
        return [];
    }

    public function getBreadCrumb(Request $request): BreadCrumbValueObject
    {
        return new BreadCrumbValueObject(
            title: 'Dashboard',
            route: new RouteValueObject('homepage')
        );
    }
}

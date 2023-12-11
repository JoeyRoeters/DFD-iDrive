<?php

namespace App\UserInterface\Domain\Devices\Controllers;

use App\Infrastructure\Custom\AbstractViewController;
use App\Infrastructure\Custom\ValueObjects\ButtonValueObject;
use App\Infrastructure\Custom\ValueObjects\PageHeaderValueOject;

class OverviewController extends AbstractViewController
{
    /**
     * @inheritdoc
     */
    protected function view(): string
    {
        return 'devices_overview';
    }

    /**
     * @inheritdoc
     */
    protected function pageHeader(): PageHeaderValueOject
    {
        return new PageHeaderValueOject(
            title: 'Devices',
            buttons: [
                ButtonValueObject::make('Add new', 'devices.mutate', 'fa-solid fa-plus', "success"),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    protected function appendViewData(): array
    {
        return [];
    }

}

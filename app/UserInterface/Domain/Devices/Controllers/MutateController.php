<?php

namespace App\UserInterface\Domain\Devices\Controllers;

use App\Infrastructure\Custom\AbstractViewController;
use App\Infrastructure\Custom\ValueObjects\ButtonValueObject;
use App\Infrastructure\Custom\ValueObjects\PageHeaderValueOject;

class MutateController extends AbstractViewController
{
    /**
     * @inheritdoc
     */
    protected function view(): string
    {
        return 'devices_mutate';
    }

    /**
     * @inheritdoc
     */
    protected function pageHeader(): PageHeaderValueOject
    {
        return new PageHeaderValueOject(
            title: 'Devices',
            buttons: [
                ButtonValueObject::make('Add new', 'homepage', 'fa-solid fa-wand-magic-sparkles'),
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

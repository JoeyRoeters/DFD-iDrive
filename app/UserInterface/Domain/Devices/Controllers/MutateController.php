<?php

namespace App\UserInterface\Domain\Devices\Controllers;

use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;

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
                ButtonValueObject::make('Cancel', 'homepage', 'fa-solid fa-xmark', 'danger'),
                ButtonValueObject::make('Save', 'homepage', 'fa-solid fa-wand-magic-sparkles', 'success'),
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

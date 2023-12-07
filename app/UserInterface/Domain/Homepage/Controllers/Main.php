<?php

namespace App\UserInterface\Domain\Homepage\Controllers;

use App\Infrastructure\Custom\AbstractViewController;
use App\Infrastructure\Custom\ValueObjects\ButtonValueObject;
use App\Infrastructure\Custom\ValueObjects\PageHeaderValueOject;

class Main extends AbstractViewController
{
    protected function view(): string
    {
        return 'homepage';
    }

    protected function pageHeader(): PageHeaderValueOject
    {
        return new PageHeaderValueOject(
            title: 'Homepage',
            buttons: [
                ButtonValueObject::make('Magic button', 'homepage', 'fa-solid fa-wand-magic-sparkles'),
            ]
        );
    }

    protected function appendViewData(): array
    {
        return [];
    }

}

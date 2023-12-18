<?php

namespace App\UserInterface\Domain\Homepage\Controllers;

use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use Illuminate\Http\Request;

class Main extends AbstractViewController
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
            buttons: [
                ButtonValueObject::make('Magic button', 'homepage', 'fa-solid fa-wand-magic-sparkles'),
            ]
        );
    }

    /**
     * @inheritdoc
     */
    protected function appendViewData(Request $request): array
    {
        return [];
    }

}

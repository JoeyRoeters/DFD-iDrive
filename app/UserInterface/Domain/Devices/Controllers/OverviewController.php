<?php

namespace App\UserInterface\Domain\Devices\Controllers;


use App\Domain\Device\Model\Device;
use App\Domain\Trip\Model\Trip;
use App\Helpers\Overview\AbstractOverviewController;
use App\Helpers\Overview\Column\Enum\ActionButtonEnum;
use App\Helpers\Overview\Column\Enum\RenderTypeEnum;
use App\Helpers\Overview\Column\ValueObject\ActionRenderType;
use App\Helpers\Overview\Column\ValueObject\Column;
use App\Helpers\Overview\Table\ValueObject\TableConfiguration;
use App\Helpers\Overview\Traits\FeedModelDataTrait;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OverviewController extends AbstractOverviewController
{
    use FeedModelDataTrait;

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



    protected function getTableConfiguration(): TableConfiguration
    {
        return new TableConfiguration(
            showHeaders: false,
            info: false,
            paging: true,
            searching: false,
            ordering: false,
            pageLength: 5,
        );
    }

    protected function getColumns(): array
    {
        return [
            new Column(
                key: 'name',
                label: 'Name',
                renderType: RenderTypeEnum::TRIP_DEVICE_LABEL,
            ),
            new Column(
                key: 'lastActive',
                label: 'Last seen',
                renderType: RenderTypeEnum::INLINE_COLUMN_NAME_WITH_TEXT,
            ),
            new Column(
                key: 'type',
                label: 'Model',
                renderType: RenderTypeEnum::INLINE_COLUMN_NAME_WITH_TEXT,
            ),
            new Column(
                key: 'actions',
                label: 'Actions',
                renderType: RenderTypeEnum::ACTION_BUTTON,
            ),
        ];
    }

    protected function getModelQuery(): Builder
    {
        return Device::query();
    }


    /**
     * @param Device $model
     * @return array
     */
    protected function processModel(Model $model): array
    {
        return [
            'name' => $model->name,
            'lastActive' => $model->getDateFormatted(),
            'type' => $model->getTimeFormatted(),
            'actions' => new ActionRenderType(
                route: 'trip.show',
                buttonEnum: ActionButtonEnum::ARROW,
                routeParam: ['id' => $model->id],
            )
        ];
    }
}

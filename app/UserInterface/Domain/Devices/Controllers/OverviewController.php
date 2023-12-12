<?php

namespace App\UserInterface\Domain\Devices\Controllers;


use App\Domain\Trip\Model\Trip;
use App\Helpers\Overview\AbstractOverviewController;
use App\Helpers\Overview\Column\Enum\ActionButtonEnum;
use App\Helpers\Overview\Column\Enum\RenderTypeEnum;
use App\Helpers\Overview\Column\ValueObject\ActionRenderType;
use App\Helpers\Overview\Column\ValueObject\Column;
use App\Helpers\Overview\Table\ValueObject\TableConfiguration;
use App\Helpers\Overview\Traits\FeedModelDataTrait;
use App\Helpers\View\Abstract\AbstractViewController;
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

    protected function getTableConfiguration(): TableConfiguration
    {
        return new TableConfiguration(
            showHeaders: false,
            info: false,
            paging: true,
            searching: false,
            ordering: false,
            pageLength: 10,
        );
    }

    protected function getColumns(): array
    {
        return [
            new Column(
                key: 'device',
                label: 'Device',
                renderType: RenderTypeEnum::TRIP_DEVICE_LABEL,
            ),
            new Column(
                key: 'date',
                label: 'Date',
                renderType: RenderTypeEnum::INLINE_COLUMN_NAME_WITH_TEXT,
            ),
            new Column(
                key: 'time',
                label: 'Time',
                renderType: RenderTypeEnum::INLINE_COLUMN_NAME_WITH_TEXT,
            ),
            new Column(
                key: 'distance',
                label: 'Distance',
                renderType: RenderTypeEnum::INLINE_COLUMN_NAME_WITH_TEXT,
            ),
            new Column(
                key: 'score',
                label: 'Score',
                renderType: RenderTypeEnum::COLORED_NUMBER_0_100,
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
        return Trip::query();
    }

    protected function processModel(Model $model): array
    {
        return [
            'device' => $model->device_id,
            'date' => $model->getDateFormatted(),
            'time' => $model->getTimeFormatted(),
            'distance' => $model->distance,
            'score' => $model->score,
            'actions' => new ActionRenderType(
                route: 'trip.show',
                routeParam: ['id' => $model->id],
                buttonEnum: ActionButtonEnum::ARROW,
            )
        ];
    }
}

<?php

namespace App\UserInterface\Domain\Trip\Controllers;

use App\Domain\Trip\Model\Trip;
use App\Helpers\Overview\AbstractOverviewController;
use App\Helpers\Overview\Column\Enum\ActionButtonEnum;
use App\Helpers\Overview\Column\Enum\RenderTypeEnum;
use App\Helpers\Overview\Column\ValueObject\ActionRenderType;
use App\Helpers\Overview\Column\ValueObject\Column;
use App\Helpers\Overview\Table\ValueObject\TableConfiguration;
use App\Helpers\Overview\Traits\FeedModelDataTrait;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use \Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Main extends AbstractOverviewController
{
    use FeedModelDataTrait;

    protected function getModelQuery(): Builder
    {
        return Trip::query();
    }

    protected function pageHeader(): PageHeaderValueOject
    {
        return new PageHeaderValueOject(
            title: 'Trips',
            buttons: [],
        );
    }

    protected function getTableConfiguration(): TableConfiguration
    {
        return new TableConfiguration();
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

    /**
     * @param Trip $model
     * @return array
     */
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

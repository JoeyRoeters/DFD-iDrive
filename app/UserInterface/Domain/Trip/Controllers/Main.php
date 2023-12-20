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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Main extends AbstractOverviewController
{
    use FeedModelDataTrait;

    protected function getModelQuery(): Builder
    {
        $query = Trip::query();
        $query->where('user_id', auth()->user()->id);
        return $query;
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
                key: 'state',
                label: 'State',
                renderType: RenderTypeEnum::INLINE_COLUMN_NAME_WITH_TEXT,
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
            'state' => $model->state->getTranslation() ?: 'Unknown',
            'date' => $model->getDateFormatted() ?: 'Unknown',
            'time' => $model->getTimeFormatted() ?: 'Unknown',
            'distance' => $model->distance ?: '0 KM',
            'score' => $model->score ?: '0.0',
            'actions' => new ActionRenderType(
                route: 'trip.show.overview',
                routeParam: ['id' => $model->id],
                buttonEnum: ActionButtonEnum::ARROW,
            )
        ];
    }
}

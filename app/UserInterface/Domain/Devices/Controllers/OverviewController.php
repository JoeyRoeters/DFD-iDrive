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
                ButtonValueObject::make('Add new', 'devices.mutate.new', 'fa-solid fa-plus', "success"),
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
                renderType: RenderTypeEnum::INLINE_COLUMN_NAME_WITH_TEXT,
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
                key: 'show',
                label: 'Show',
                renderType: RenderTypeEnum::ACTION_BUTTON,
            ),
            new Column(
                key: 'edit',
                label: 'Edit',
                renderType: RenderTypeEnum::ACTION_BUTTON,
            ),
        ];
    }

    protected function getModelQuery(): Builder
    {
        $query = Device::query();
        $query->where('user_id', auth()->user()->id);
        return $query;
    }


    /**
     * @param Device $model
     * @return array
     */
    protected function processModel(Model $model): array
    {
        return [
            'name' => $model->name,
            'lastActive' => $model->getDateFormatted() ?: 'Never',
            'type' => $model->type?->getLabel() ?: 'Unknown',
            'show' => new ActionRenderType(
                route: 'devices.show',
                buttonEnum: ActionButtonEnum::BUTTON,
                routeParam: ['id' => $model->id],
                label: 'Show',
                color: 'primary',
            ),
            'edit' => new ActionRenderType(
                route: 'devices.mutate.edit',
                buttonEnum: ActionButtonEnum::BUTTON,
                routeParam: ['id' => $model->id],
                label: 'Edit',
                color: 'success',
            )
        ];
    }
}

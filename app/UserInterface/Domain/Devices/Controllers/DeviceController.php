<?php

namespace App\UserInterface\Domain\Devices\Controllers;

use App\Domain\Device\Model\Device;
use App\Helpers\Overview\AbstractOverviewController;
use App\Helpers\Overview\Column\Enum\ActionButtonEnum;
use App\Helpers\Overview\Column\Enum\RenderTypeEnum;
use App\Helpers\Overview\Column\ValueObject\ActionRenderType;
use App\Helpers\Overview\Column\ValueObject\Column;
use App\Helpers\Overview\Table\ValueObject\TableConfiguration;
use App\Helpers\Overview\Table\ValueObject\TableDataRequest;
use App\Helpers\Overview\Traits\FeedModelDataTrait;
use App\Helpers\SweetAlert\SweetAlert;
use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use App\UserInterface\Domain\Devices\Requests\MutateDeviceRequest;
use App\UserInterface\Domain\Devices\Requests\ShowDeviceRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DeviceController extends AbstractOverviewController
{

    use FeedModelDataTrait;

    public Request $request;
    public Device $device;

    /**
     * @inheritdoc
     */
    protected function view(): string
    {
        return 'devices_show';
    }


    /**
     * @param ShowDeviceRequest|Request $request
     */
    protected function loadData(Request $request): void
    {
        $this->request = $request;
        $this->device = Device::where('_id', $request->route('id'))
            ->where('user_id', auth()->id())
            ->with("user")
            ->with("trips")
            ->first();
    }

    /**
     * @inheritdoc
     */
    protected function pageHeader(): PageHeaderValueOject
    {
        return new PageHeaderValueOject(
            title: 'Devices',
            buttons: [
            ]
        );
    }

    /**
     * @inheritdoc
     */
    protected function appendViewData(): array
    {
        return [
            'device' => $this->device,
            'tableConfiguration' => $this->getTableConfiguration(),
            'columns' => array_map(fn (Column $column) => $column->toArray(), $this->getColumns())
        ];

    }

    protected function getModelQuery(): Builder
    {
        return Device::query();
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


    /**
     * @param Device $model
     * @return array
     */
    protected function processModel(Model|\Illuminate\Database\Eloquent\Model $model): array
    {

        return [
            'name' => $model->name,
            'lastActive' => $model->getDateFormatted() ?: 'Never',
            'type' => $model->type,
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

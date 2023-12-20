<?php

namespace App\UserInterface\Domain\Devices\Controllers;

use App\Domain\Device\Model\Device;
use App\Domain\Trip\Model\Trip;
use App\Domain\User\Model\User;
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
use MongoDB\Laravel\Eloquent\Model;

class DeviceController extends AbstractOverviewController
{
    use FeedModelDataTrait;

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
            title: 'Devices'
        );
    }

    /**
     * @inheritdoc
     */
    protected function appendViewData(Request $request): array
    {
        return [
            'api_token' => auth()->user()->getApiToken($this->device),
            'device' => $this->device,
            'tableConfiguration' => $this->getTableConfiguration(),
            'deleteButton'  => ButtonValueObject::make(
                label: 'Delete',
                route: route("devices.delete.confirm", ["id" => $request->route('id')]),
                icon: 'fa-solid fa-trash',
                color: 'danger',
                confirmMessage: "Are you sure you want to delete this device?",
            ),
            'columns' => array_map(fn (Column $column) => $column->toArray(), $this->getColumns())
        ];

    }

    protected function getModelQuery(): Builder
    {
        $query = Trip::query();
        $query->where('user_id', auth()->user()->id);
        $query->where('device_id', $this->device->id);
        return $query;
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
                key: 'id',
                label: 'ID',
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
                renderType: RenderTypeEnum::INLINE_COLUMN_NAME_WITH_TEXT,
            ),
        ];
    }


    /**
     * @param Trip $model
     * @return array
     */
    protected function processModel(Model|\Illuminate\Database\Eloquent\Model $model): array
    {

        return [
            'id' => $model->trip_number,
            'date' => $model->getDateFormatted() ?: 'Never',
            'time' => ($model->start_time ? $model->start_time->format('H:i') : 'N/A') . ' - ' . ($model->end_time ? $model->start_time->format('H:i') : 'N/A'),
            'distance' => $model->distance ?: '0 KM',
            'score' => $model->score ?: '0.0',
        ];

    }


}

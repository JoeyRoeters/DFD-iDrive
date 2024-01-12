<?php

namespace App\UserInterface\Domain\Devices\Controllers;

use App\Domain\Device\Model\Device;
use App\Domain\Shared\Interface\BreadCrumbInterface;
use App\Domain\Shared\ValueObject\BreadCrumbValueObject;
use App\Domain\Shared\ValueObject\RouteValueObject;
use App\Domain\Trip\Model\Trip;
use App\Domain\User\Model\User;
use App\Helpers\Overview\AbstractOverviewController;
use App\Helpers\Overview\Column\Enum\ActionButtonEnum;
use App\Helpers\Overview\Column\Enum\RenderTypeEnum;
use App\Helpers\Overview\Column\ValueObject\ActionRenderType;
use App\Helpers\Overview\Column\ValueObject\Column;
use App\Helpers\Overview\Column\ValueObject\MultiActionRenderType;
use App\Helpers\Overview\Table\Interface\EmptyTableViewInterface;
use App\Helpers\Overview\Table\ValueObject\EmptyViewValueObject;
use App\Helpers\Overview\Table\ValueObject\TableConfiguration;
use App\Helpers\Overview\Traits\FeedModelDataTrait;
use App\Helpers\View\Enum\ButtonSizeEnum;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class OverviewController extends AbstractOverviewController implements BreadCrumbInterface, EmptyTableViewInterface
{
    use FeedModelDataTrait;

    /**
     * @inheritdoc
     */
    protected function pageHeader(): PageHeaderValueOject
    {
        $buttons = [];
        if (!$this->isEmpty()) {
            $buttons[] = new ButtonValueObject(
                label: 'Add Device',
                route: new RouteValueObject('devices.mutate.new'),
                icon: 'fa-solid fa-plus',
                size: ButtonSizeEnum::LARGE
            );
        }
        return new PageHeaderValueOject(
            title: 'Devices',
            buttons: $buttons
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
                key: 'trips',
                label: 'Trips',
                renderType: RenderTypeEnum::INLINE_COLUMN_NAME_WITH_TEXT,
            ),
            new Column(
                key: 'actions',
                label: 'Actions',
                renderType: RenderTypeEnum::MULTI_ACTION_BUTTON,
            ),
        ];
    }

    protected function getModelQuery(): Builder
    {
        $query = Device::query();
        $query->where('user_id', auth()->user()->id);

        //REMOVE
        //        $query->where('is_active', true);
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
            'trips' => $model->getTotalTrips(),
            'actions' => new MultiActionRenderType(
                actions: [
                    new ActionRenderType(
                        route: 'devices.show',
                        buttonEnum: ActionButtonEnum::ARROW,
                        routeParam: ['id' => $model->id],
                    )
                ]
            ),
        ];
    }

    public function getBreadCrumb(Request $request): BreadCrumbValueObject
    {
        return new BreadCrumbValueObject(
            title: 'Devices',
            route: new RouteValueObject('devices.overview'),
            parentClass: \App\UserInterface\Domain\Homepage\Controllers\Main::class,
        );
    }

    public function isEmpty(): bool
    {
        /** @var $user User */
        return !auth()->user()->hasDevices();
    }

    public function getEmptyViewValueObject(): EmptyViewValueObject
    {
        return new EmptyViewValueObject(
            title: 'Add your first device',
            description: "Your device list is empty. Kickstart your journey by adding your first device. Connect now and let the discoveries begin!",
            image: 'resources/images/Illustrations/missing_device.svg',
            buttonValueObject: new ButtonValueObject(
                label: 'Add Device',
                route: new RouteValueObject('devices.mutate.new'),
                icon: 'fa-solid fa-plus',
                size: ButtonSizeEnum::LARGE
            )
        );
    }
}

<?php

namespace App\UserInterface\Domain\Trip\Controllers;

use App\Domain\Shared\Interface\BreadCrumbInterface;
use App\Domain\Shared\ValueObject\BreadCrumbValueObject;
use App\Domain\Shared\ValueObject\RouteValueObject;
use App\Domain\Trip\Enum\TripStateEnum;
use App\Domain\Trip\Model\Trip;
use App\Helpers\Overview\AbstractOverviewController;
use App\Helpers\Overview\Column\Enum\ActionButtonEnum;
use App\Helpers\Overview\Column\Enum\RenderTypeEnum;
use App\Helpers\Overview\Column\ValueObject\ActionRenderType;
use App\Helpers\Overview\Column\ValueObject\Column;
use App\Helpers\Overview\Column\ValueObject\TripLabelRenderType;
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

class Main extends AbstractOverviewController implements BreadCrumbInterface, EmptyTableViewInterface
{
    use FeedModelDataTrait;

    private static bool $disableSearch = false;

    public static function setDisableSearch(bool $value): void
    {
        self::$disableSearch = $value;
    }

    protected function getModelQuery(): Builder
    {
        $query = Trip::query();
        $query->where('user_id', auth()->user()->id);
        $query->where('state', TripStateEnum::FINISHED->value);
//        $query->where('is_active', true);

        $query->orderBy('number', 'desc');


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
            searching: !self::$disableSearch,
            ordering: false,
            pageLength: 10,
        );
    }

    protected function getColumns(): array
    {
        return [
            new Column(
                key: 'trip_label',
                label: 'Device',
                renderType: RenderTypeEnum::TRIP_LABEL,
                width: 2,
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
            'trip_label' => new TripLabelRenderType(
                tripNumber: $model->getNumberFormatted() ?: 0,
                deviceName: $model->getDeviceName(),
            ),
            'date' => $model->getDateFormatted(),
            'time' => $model->getTimeFormatted(),
            'distance' => $model->getDistanceFormatted(),
            'score' => $model->getScoreFormatted(),
            'actions' => new ActionRenderType(
                route: 'trip.show',
                routeParam: ['id' => $model->id],
                buttonEnum: ActionButtonEnum::ARROW,
            )
        ];
    }

    public function getBreadCrumb(Request $request): BreadCrumbValueObject
    {
        return new BreadCrumbValueObject(
            title: 'Trips',
            route: new RouteValueObject('trip.main'),
            parentClass: \App\UserInterface\Domain\Homepage\Controllers\Main::class
        );
    }

    public function isEmpty(): bool
    {
        return $this->getModelQuery()->count() === 0;
    }

    public function getEmptyViewValueObject(): EmptyViewValueObject
    {
        /** @var \App\Domain\User\Model\User $user */
        $user = auth()->user();
        if (!$user->hasActiveDevices()) {
            return new EmptyViewValueObject(
                title: 'Your Journey Awaits',
                description: "Your travel log is just waiting to be filled. Start driving and your trips will automatically appear here, ready for you to explore and analyze. When you're ready, hit the road and we'll take care of the rest",
                image: 'resources/images/Illustrations/empty_trips.svg',
            );
        }

        if ($user->hasPendingDevices()) {
            $device = $user->getPendingDevices()[0];

            return new EmptyViewValueObject(
                title: 'Device Awaiting Setup',
                description: "Connect your device '{$device->name}' to unlock valuable insights. Keep tabs on your trips, analyze your driving habits, and make every journey more efficient. Tap 'Setup Device' to begin.",
                image: 'resources/images/Illustrations/setup_device.svg',
                buttonValueObject: new ButtonValueObject(
                    label: 'Setup Device',
                    route: new RouteValueObject('devices.show', ['id' => $device->id]),
                    icon: 'fa-solid fa-plus',
                    size: ButtonSizeEnum::LARGE
                )
            );
        }

        return new EmptyViewValueObject(
            title: 'No devices added yet',
            description: "Your trips overview is currently empty. To begin tailoring your journey, simply click the 'Add Device' button below. Connect your device to unlock a world of driving feedback and start your adventure.",
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

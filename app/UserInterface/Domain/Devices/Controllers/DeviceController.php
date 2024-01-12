<?php

namespace App\UserInterface\Domain\Devices\Controllers;

use App\Domain\Device\Model\Device;
use App\Domain\Shared\Interface\BreadCrumbInterface;
use App\Domain\Shared\ValueObject\BreadCrumbValueObject;
use App\Domain\Shared\ValueObject\RouteValueObject;
use App\Domain\Trip\Model\Trip;
use App\Domain\User\Model\User;
use App\Helpers\Guide\ValueObject\GuideItemValueObject;
use App\Helpers\Guide\ValueObject\GuideValueObject;
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
use App\UserInterface\Domain\Trip\Controllers\Main;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MongoDB\Laravel\Eloquent\Model;

class DeviceController extends AbstractViewController implements  BreadCrumbInterface
{
    protected Device $device;

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
    public function loadData(Request $request): void
    {
        $this->device = Device::findOrFail($request->id);
    }

    /**
     * @inheritdoc
     */
    protected function pageHeader(): PageHeaderValueOject
    {
        $routeParameters = ['id' => $this->device->id];

        return new PageHeaderValueOject(
            title: 'Device',
            buttons: [
                new ButtonValueObject(
                    label: 'Edit',
                    route: new RouteValueObject('devices.mutate.edit', $routeParameters),
                    icon: 'fa-solid fa-edit'
                ),
                new ButtonValueObject(
                    label: 'Delete',
                    route: new RouteValueObject('devices.delete.confirm', $routeParameters),
                    icon: 'fa-solid fa-trash',
                    color: 'danger',
                    confirmMessage: 'Are you sure you want to delete this device?'
                )
            ]
        );
    }

    /**
     * @inheritdoc
     */
    protected function appendViewData(Request $request): array
    {
        $setup = new GuideValueObject(
            title: 'Setup your device',
            description: 'Follow these steps to integrate your device with the VAR platform. This process will enable the simulator to communicate with the platform and access the services it provides.',
            items: $this->device->isSimulator() ? $this->getSetupGuideSimulator() : $this->getSetupGuideCar(),
        );

        Main::setDisableSearch(true);

        return [
            'apiToken' => auth()->user()->getApiToken($this->device),
            'device' => $this->device,
            ...Main::getCleanViewData($request),
            'fetchUrl' => route('trip.main'),
            'stepper' => $setup,
        ];

    }

    private function getSetupGuideSimulator() : array
    {
        $apiToken = auth()->user()->getApiToken($this->device);

        return [
            GuideItemValueObject::make(
                title: 'Copy the API Key',
                description: "Start by copying the API key by clicking the button below. This unique key is essential for establishing a connection between your simulator and the services it accesses.",
                icon: 'fa-solid fa-copy',
                button: new ButtonValueObject(
                    label: 'Copy API Key',
                    icon: 'fa-solid fa-copy',
                    jsFunction: "navigator.clipboard.writeText(\"${apiToken}\")"
                )
            ),
            GuideItemValueObject::make(
                title: 'Accessing Bridge Configuration',
                description: "Open the simulator and navigate to the bridge configuration settings. This area is where you'll integrate the API key to enable communication with external applications.",
                icon: 'fa-solid fa-gear'
            ),
            GuideItemValueObject::make(
                title: 'Entering the API Key',
                description: "In the bridge configuration settings, find the designated field for the API key. Paste the key you copied earlier into this field, ensuring no extra spaces or characters are included.",
                icon: 'fa-solid fa-paste'
            ),
            GuideItemValueObject::make(
                title: 'Saving Your Settings',
                description: "With the API key in place, save your new configuration. This step is crucial to solidify the changes you've made and prepare for a connection test.",
                icon: 'fa-solid fa-floppy-disk'
            ),
            GuideItemValueObject::make(
                title: 'Verifying the Connection',
                description: "Finally, check the connection status. A green indicator typically signifies a successful link, confirming that the API key is active and the simulator is ready to operate with the new settings.",
                icon: 'fa-solid fa-check-double'
            )
        ];
    }

    private function getSetupGuideCar(): array
    {
        $apiToken = auth()->user()->getApiToken($this->device);

        return [
            GuideItemValueObject::make(
                title: 'Copy the API Key',
                description: "Start by copying the API key by clicking the button below. This unique key is essential for establishing a connection between your device and the services it accesses.",
                icon: 'fa-solid fa-copy',
                button: new ButtonValueObject(
                    label: 'Copy API Key',
                    icon: 'fa-solid fa-copy',
                    jsFunction: "navigator.clipboard.writeText(\"${apiToken}\")"
                )
            ),
            GuideItemValueObject::make(
                title: 'Download Modified Software',
                description: "Download the modified version of the software specifically designed for your comma3x device. The download link can be found below. This version includes necessary configurations for optimal performance.",
                icon: 'fa-solid fa-download',
                button: new ButtonValueObject(
                    label: 'Download latest software',
                    icon: 'fa-brands fa-github',
                    route: new RouteValueObject('https://github.com/commaai/openpilot/releases/tag/', [], true)
                )
            ),
            GuideItemValueObject::make(
                title: 'Locate and Edit Configuration File',
                description: "Find the configuration file in the first folder of the modified software version. Open this file and locate the API key field.",
                icon: 'fa-solid fa-folder-open'
            ),
            GuideItemValueObject::make(
                title: 'Paste the API Key and Save',
                description: "Paste the copied API key into the designated field in the configuration file. Ensure that no extra spaces or characters are included. Save the configuration file by pressing Ctrl+S.",
                icon: 'fa-solid fa-paste'
            ),
            GuideItemValueObject::make(
                title: 'Upload Software and Test Device',
                description: "Upload the newly configured software to your comma3x device. Follow the instructions for proper upload and then start the device to test the new settings.",
                icon: 'fa-solid fa-upload'
            )
        ];
    }

    public function getBreadCrumb(Request $request): BreadCrumbValueObject
    {
        return new BreadCrumbValueObject(
            title: 'Device: ' . $this->device->name,
            route: new RouteValueObject('devices.show', ['id' => $this->device->id]),
            parentClass: OverviewController::class
        );
    }
}

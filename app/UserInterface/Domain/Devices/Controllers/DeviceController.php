<?php

namespace App\UserInterface\Domain\Devices\Controllers;

use App\Domain\Device\Model\Device;
use App\Helpers\SweetAlert\SweetAlert;
use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use App\UserInterface\Domain\Devices\Requests\MutateDeviceRequest;
use App\UserInterface\Domain\Devices\Requests\ShowDeviceRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DeviceController extends AbstractViewController
{
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
        ];

    }

}

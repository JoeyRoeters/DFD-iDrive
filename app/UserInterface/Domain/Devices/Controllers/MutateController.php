<?php

namespace App\UserInterface\Domain\Devices\Controllers;

use App\Domain\Device\Model\Device;
use App\Helpers\SweetAlert\SweetAlert;
use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use App\UserInterface\Domain\Devices\Requests\DeviceRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MutateController extends AbstractViewController
{
    public Request $request;

    /**
     * @inheritdoc
     */
    protected function view(): string
    {
        return 'devices_mutate';
    }

    protected function loadData(Request $request): void
    {
        $this->request = $request;
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
        if ($this->request->route()->getName() === 'devices.mutate.edit') {
            return [
                'device' => Device::find($this->request->route()->parameter('id')),
            ];
        }

        return [];
    }


    /**
     * @throws ValidationException
     */
    public function save(DeviceRequest $request)
    {
        if ($request->post("device_id") !== null) {
            $device = Device::find($request->post("device_id"));
            $device->name = $request->input('devicename');
            $device->type = $request->input('devicetype');

            if ($device->save()) {
                SweetAlert::createInfo("Device updated!");
                return redirect()->route('devices.overview');
            } else {
                SweetAlert::createError("Device could not be updated!");
                throw ValidationException::withMessages(['error' => 'Something went wrong']);
            }
        } else {
            $device = new Device();
            $device->name = $request->input('devicename');
            $device->type = $request->input('devicetype');
            if ($device->save()) {
                SweetAlert::createInfo("Device created!");
                return redirect()->route('devices.overview');
            } else {
                SweetAlert::createError("Device could not be created!");
                throw ValidationException::withMessages(['error' => 'Something went wrong']);
            }

        }
    }

}

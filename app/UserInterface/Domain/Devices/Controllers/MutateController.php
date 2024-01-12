<?php

namespace App\UserInterface\Domain\Devices\Controllers;

use App\Domain\Device\Model\Device;
use App\Domain\Shared\Interface\BreadCrumbInterface;
use App\Domain\Shared\ValueObject\BreadCrumbValueObject;
use App\Domain\Shared\ValueObject\RouteValueObject;
use App\Helpers\SweetAlert\SweetAlert;
use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use App\UserInterface\Domain\Devices\Requests\MutateDeviceRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class MutateController extends AbstractViewController implements BreadCrumbInterface
{
    private ?Device $device;

    /**
     * @inheritdoc
     */
    protected function view(): string
    {
        return 'devices_mutate';
    }

    /**
     * @inheritdoc
     */
    protected function pageHeader(): PageHeaderValueOject
    {
        return new PageHeaderValueOject(
            title: $this->device instanceof Device ? 'Edit device' : 'Add new device',
        );
    }

    public function loadData(Request $request): void
    {
        $this->device = Device::find($request->route()->parameter('id'));
    }

    /**
     * @inheritdoc
     */
    protected function appendViewData(Request $request): array
    {
        if ($request->route()->getName() === 'devices.mutate.edit') {
            return [
                'device' => Device::find($request->route()->parameter('id')),
            ];
        }

        return [];
    }


    /**
     * @throws ValidationException
     */
    public function save(MutateDeviceRequest $request)
    {
        $device = Device::find($request->post("device_id"));
        if (!$device instanceof Device) {
            $device = new Device();
            $device->user_id = auth()->user()->id;
        }

        $device->name = $request->input('devicename');
        $device->type = $request->input('devicetype');

        $type = $device->id === null ? "created" : "updated";
        if (!$device->save()) {
            SweetAlert::createError("Device could not be $type!");

            throw ValidationException::withMessages(['error' => 'Something went wrong']);
        }

        SweetAlert::createSuccess("Device $type!");

        return redirect()->route('devices.overview');
    }

    public function getBreadCrumb(Request $request): BreadCrumbValueObject
    {
        if (!$this->device instanceof Device) {
            return new BreadCrumbValueObject(
                title: 'Add new device',
                route: new RouteValueObject('devices.mutate.create'),
                parentClass: OverviewController::class,
            );
        }

        return new BreadCrumbValueObject(
            title: 'Edit',
            route: new RouteValueObject('devices.mutate.edit', ['id' => $this->device->id]),
            parentClass: DeviceController::class,
        );
    }
}

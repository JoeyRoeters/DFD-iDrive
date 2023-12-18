<?php

namespace App\UserInterface\Domain\Devices\Controllers;

use App\Domain\Device\Model\Device;
use App\Helpers\SweetAlert\SweetAlert;
use App\Helpers\View\Abstract\AbstractViewController;
use App\Helpers\View\ValueObject\ButtonValueObject;
use App\Helpers\View\ValueObject\PageHeaderValueOject;
use App\Infrastructure\Laravel\Controller;
use App\UserInterface\Domain\Devices\Requests\MutateDeviceRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DeleteController extends Controller
{
    public function deleteMessage(Request $request)
    {
        $device = Device::find($request->route('id'));

        if (!$this->hasDeviceAccess($device)) {
            SweetAlert::createError("Device could not be deleted!");

            return redirect()->back('devices.overview');
        }

        SweetAlert::createConfirm(
            "Are you sure you want to delete this device?",
            route("devices.delete.confirm", ["id" => $request->route('id')])
        );

        return redirect()->back();
    }

    public function deleteDevice(Request $request)
    {
        $device = Device::find($request->route('id'));

        if (!$this->hasDeviceAccess($device) || !$device->delete()) {
            SweetAlert::createError("Device could not be deleted!");

            throw ValidationException::withMessages(['error' => 'Something went wrong']);
        }

        SweetAlert::createSuccess("Device deleted!");
        return redirect()->route('devices.overview');
    }

    private function hasDeviceAccess(mixed $device): bool
    {
        if (!$device instanceof Device) {
            return false;
        }

        return $device->hasAccess(auth()->user());
    }

}

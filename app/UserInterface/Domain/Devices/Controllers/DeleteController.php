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

        if ($device != null && $device->user_id != auth()->id()) {
            SweetAlert::createError("Device could not be deleted!");
            return redirect()->back('devices.overview');
        } else {
            SweetAlert::createConfirm(
                "Are you sure you want to delete this device?",
                route("devices.delete.confirm", ["id" => $request->route('id')])
            );
            return redirect()->back();
        }
    }

    public function deleteDevice(Request $request)
    {
        $device = Device::find($request->route('id'));
        if ($device->user_id != auth()->id()) {
            SweetAlert::createError("Device could not be deleted!");
            throw ValidationException::withMessages(['error' => 'Something went wrong']);
        }

        if ($device->delete()) {
            SweetAlert::createSuccess("Device deleted!");
            return redirect()->route('devices.overview');
        } else {
            SweetAlert::createError("Device could not be deleted!");
            throw ValidationException::withMessages(['error' => 'Something went wrong']);
        }
    }


}

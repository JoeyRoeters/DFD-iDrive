<?php

namespace App\Domain\Device\Repository;

use App\Domain\Device\Interface\DeviceRepositoryInterface;
use App\Domain\Device\Model\Device;
use Illuminate\Support\Collection;

class DeviceRepository implements DeviceRepositoryInterface
{
    public function createDevice(array $data): Device
    {
        return Device::create($data);
    }

    public function getDeviceById(int $id): ?Device
    {
        return Device::find($id);
    }

    public function getUserDevices(string $userId): Collection
    {
        return Device::where('user_id', $userId)->get();
    }

    public function getAllDevices(): Collection
    {
        return Device::all();
    }

    public function updateDevice(int $id, array $data): bool
    {
        $Device = Device::find($id);

        if (!$Device) {
            return false;
        }

        $Device->update($data);

        return true;
    }
}

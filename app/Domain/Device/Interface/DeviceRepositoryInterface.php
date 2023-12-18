<?php

namespace App\Domain\Device\Interface;

use App\Domain\Device\Model\Device;
use Illuminate\Support\Collection;

interface DeviceRepositoryInterface
{
    /**
     * @param array<string, mixed> $data
     * @return Device
     */
    public function createDevice(array $data): Device;

    /**
     * @param int $id
     * @return Device|null
     */
    public function getDeviceById(int $id): ?Device;

    /**
     * @param string $userId
     * @return Collection
     */
    public function getUserDevices(string $userId): Collection;

    /**
     * @return Collection
     */
    public function getAllDevices(): Collection;

    /**
     * @param int $id
     * @param array<string, mixed> $data
     * @return bool
     */
    public function updateDevice(int $id, array $data): bool;
}

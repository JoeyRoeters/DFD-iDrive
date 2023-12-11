<?php

namespace App\Domain\Trips\Interface;

use App\Domain\Trips\Model\Trip;
use Illuminate\Support\Collection;

interface TripRepositoryInterface
{
    /**
     * @param array<string, mixed> $data
     * @return Trip
     */
    public function createTrip(array $data): Trip;

    /**
     * @param int $id
     * @return Trip|null
     */
    public function getTripById(int $id): ?Trip;

    /**
     * @param string $userId
     * @return Collection
     */
    public function getUserTrips(string $userId): Collection;

    /**
     * @return Collection
     */
    public function getAllTrips(): Collection;

    /**
     * @param int $id
     * @param array<string, mixed> $data
     * @return bool
     */
    public function updateTrip(int $id, array $data): bool;
}

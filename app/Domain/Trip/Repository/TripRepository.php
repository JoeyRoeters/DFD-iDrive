<?php

namespace App\Domain\Trips\Repository;

use App\Domain\Trips\Interface\TripRepositoryInterface;
use App\Domain\Trips\Model\Trip;
use Illuminate\Support\Collection;

class TripRepository implements TripRepositoryInterface
{
    public function createTrip(array $data): Trip
    {
        return Trip::create($data);
    }

    public function getTripById(int $id): ?Trip
    {
        return Trip::find($id);
    }

    public function getUserTrips(string $userId): Collection
    {
        return Trip::where('user_id', $userId)->get();
    }

    public function getAllTrips(): Collection
    {
        return Trip::all();
    }

    public function updateTrip(int $id, array $data): bool
    {
        $trip = Trip::find($id);

        if (!$trip) {
            return false;
        }

        $trip->update($data);

        return true;
    }
}

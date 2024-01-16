<?php

namespace App\Domain\Trip\ValueObject\Statistic\Profile;

use App\Domain\Trip\Model\TripEvent;
use App\Domain\Trip\ValueObject\Statistic\ProfileEventValueObject;
use App\Domain\Trip\ValueObject\Statistic\ProfileValueObject;
use Illuminate\Support\Collection;

class TimelineValueObject
{
    private array $profileEvents;

    public function __construct(
        private Collection $events,
    )
    {
        $events = $events->map(function (TripEvent $event) {
            return new ProfileEventValueObject(
                event: $event->type,
                distance: $event->distance ?? 0,
                value: $event->getData(),
            );
        })->toArray();

        $eventsOrdered = [];
        foreach ($events as $event) {
            $distance = $event->getDistance();


            $eventInRange = $this->getEventInRange($event, $eventsOrdered);
            if ($eventInRange instanceof ProfileEventValueObject) {
                if ($this->hasHigherPriority($event, $eventInRange)) {
                    continue;
                }

                unset($eventsOrdered[$eventInRange->getDistance()]);
            }

            $eventsOrdered[$distance] = $event;
        }

        $this->profileEvents = array_values($eventsOrdered);
    }

    private function getEventInRange(ProfileEventValueObject $event, array $eventsOrdered): ?ProfileEventValueObject
    {
        $distance = $event->getDistance();

        for($i = $distance - 7; $i < $distance + 15; $i++) {
            if (array_key_exists($i, $eventsOrdered)) {
                return $eventsOrdered[$i];
            }
        }

        return null;
    }

    private function hasHigherPriority(ProfileEventValueObject $event, ProfileEventValueObject $inRange): bool
    {
        return $inRange->getSeverityLevel() > $event->getSeverityLevel();
    }

    public function getProfileEvents(): array
    {
        return $this->profileEvents;
    }
}

<?php

namespace App\Domain\Trip\Helper\Parsers\Profile;

use App\Domain\Trip\Enum\TripEventEnum;
use App\Domain\Trip\Enum\TripStatisticParserEnum;
use App\Domain\Trip\Model\Trip;
use App\Domain\Trip\Model\TripEvent;
use App\Domain\Trip\Model\TripStatistic;
use App\Domain\Trip\ValueObject\Statistic\Profile\TimelineValueObject;
use App\Domain\Trip\ValueObject\Statistic\ProfileStatisticValueObject;
use App\Domain\Trip\ValueObject\Statistic\ProfileValueObject;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractProfileParser
{
    protected TripStatistic $profile;

    public function __construct(
        protected Trip $trip,
    ) {
        $this->profile = $this->getTripStatistic();

        $data = $this->profile->data ?? [];
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    abstract public function parse(Trip $trip): void;

    abstract protected function getParserEnum(): TripStatisticParserEnum;

    /**
     * @return ProfileStatisticValueObject[]
     */
    abstract protected function getProfileTitle(): string;

    abstract protected function getProfileStatistics(): array;

    public function getProfile(): ProfileValueObject
    {
        return new ProfileValueObject(
            title: $this->getProfileTitle(),
            statistics: $this->getProfileStatistics(),
            events: $this->getTimeLineEvents()->getProfileEvents()
        );
    }

    protected function getTripStatistic(bool $override = false): TripStatistic
    {
        $profile = $this->trip->statistics()->where('parser', $this->getParserEnum())->first();
        if ($profile instanceof TripStatistic) {
            if ($override) {
                $profile->delete();
            } else {
                return $profile;
            }
        }

        return new TripStatistic([
            'parser' => $this->getParserEnum(),
            'trip_id' => $this->trip->id,
        ]);
    }

    protected function getEvents(): Collection
    {
        return $this->trip
            ->events()
            ->where('is_processed', true)
            ->whereIn('type', $this->getParserEnum()->getEventEnums())
            ->get();
    }

    private function fakeData(Collection &$events): void
    {
        foreach (TripEventEnum::values() as $event) {
            $event = TripEventEnum::from($event);
            if (!in_array($event, $this->getParserEnum()->getEventEnums())) {
                continue;
            }

            for($i = 0; $i < rand(2, 5); $i++) {
                $data = [];
                if ($event === TripEventEnum::SPEEDING) {
                    $data = [
                        'speed' => rand(0, 100),
                        'speed_limit' => rand(0, 100),
                    ];
                }

                $events->push(new TripEvent([
                    'type' => $event,
                    'trip_id' => $this->trip->id,
                    'distance' => rand(0, 100),
                    'data' => $data,
                ]));
            }
        }
    }

    protected function getTimeLineEvents(): TimelineValueObject
    {
        $events = $this->getEvents();

        //        $this->fakeData($events);

        return new TimelineValueObject($events);
    }

    protected function countEvents(TripEventEnum $event): int
    {
        return $this->getEvents()->where('type', $event)->count();
    }
}

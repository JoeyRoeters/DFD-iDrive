<?php

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\Interface\DateTimeInterface;
use App\Domain\Shared\Interface\ValueObjectInterface;
use DateTimeZone;

final class DateTimeValueObject extends \DateTimeImmutable implements ValueObjectInterface, DateTimeInterface
{
    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function equals(ValueObjectInterface $valueObject): bool
    {
        if (!$valueObject instanceof DateTimeInterface) {
            return false;
        }

        return $this->getTimestamp() === $valueObject->getTimestamp();
    }

    public function value(): string
    {
        return $this->setTimezone(new DateTimeZone(static::DATETIME_ZONE))->format(static::DATETIME_FORMAT);
    }

    public function isEmpty(): bool
    {
        return empty($this->value());
    }

    public static function fromPrimitives(string $datetime): static
    {
        return new self($datetime);
    }

    public static function create(): static
    {
        return new self();
    }

    public function isFuture(): bool
    {
        return $this->getTimestamp() > time();
    }

    public function isPast(): bool
    {
        return $this->getTimestamp() < time();
    }

    public function isToday(): bool
    {
        return $this->format('Y-m-d') === date('Y-m-d');
    }

    public function isTomorrow(): bool
    {
        return $this->format('Y-m-d') === date('Y-m-d', strtotime('+1 day'));
    }

    public function isYesterday(): bool
    {
        return $this->format('Y-m-d') === date('Y-m-d', strtotime('-1 day'));
    }

    public function isWeekend(): bool
    {
        return in_array($this->format('w'), [0, 6]);
    }

    public function isWeekday(): bool
    {
        return !$this->isWeekend();
    }

    public function isCurrentWeek(): bool
    {
        return $this->format('W') === date('W');
    }

    public function isCurrentMonth(): bool
    {
        return $this->format('m') === date('m');
    }

    public function isCurrentYear(): bool
    {
        return $this->format('Y') === date('Y');
    }

    public function isLeapYear(): bool
    {
        return $this->format('L') === date('L');
    }

    public function isMorning(): bool
    {
        return $this->format('H') >= 5 && $this->format('H') < 12;
    }

    public function isAfternoon(): bool
    {
        return $this->format('H') >= 12 && $this->format('H') < 17;
    }

    public function isEvening(): bool
    {
        return $this->format('H') >= 17 && $this->format('H') < 21;
    }

    public function isNight(): bool
    {
        return $this->format('H') >= 21 || $this->format('H') < 5;
    }

    public function deductDays(int $days): static
    {
        return $this->modify("-{$days} days");
    }

    public function deductWeeks(int $weeks): static
    {
        return $this->modify("-{$weeks} weeks");
    }

    public function deductMonths(int $months): static
    {
        return $this->modify("-{$months} months");
    }

    public function deductYears(int $years): static
    {
        return $this->modify("-{$years} years");
    }

    public function addDays(int $days): static
    {
        return $this->modify("+{$days} days");
    }

    public function addWeeks(int $weeks): static
    {
        return $this->modify("+{$weeks} weeks");
    }

    public function addMonths(int $months): static
    {
        return $this->modify("+{$months} months");
    }

    public function addYears(int $years): static
    {
        return $this->modify("+{$years} years");
    }

    public function getDay(): int
    {
        return (int) $this->format('d');
    }

    public function getMonth(): int
    {
        return (int) $this->format('m');
    }

    public function getYear(): int
    {
        return (int) $this->format('Y');
    }

    public function getHour(): int
    {
        return (int) $this->format('H');
    }

    public function getMinute(): int
    {
        return (int) $this->format('i');
    }

    public function getSecond(): int
    {
        return (int) $this->format('s');
    }

    public function addSeconds(int $seconds): static
    {
        return $this->modify("+{$seconds} seconds");
    }

    public function addMinutes(int $minutes): static
    {
        return $this->modify("+{$minutes} minutes");
    }

    public function addHours(int $hours): static
    {
        return $this->modify("+{$hours} hours");
    }

    public function deductSeconds(int $seconds): static
    {
        return $this->modify("-{$seconds} seconds");
    }

    public function deductMinutes(int $minutes): static
    {
        return $this->modify("-{$minutes} minutes");
    }

    public function deductHours(int $hours): static
    {
        return $this->modify("-{$hours} hours");
    }

    public function getTimestamp(): int
    {
        return (int) $this->format('U');
    }

    public function isBefore(DateTimeInterface $datetime): bool
    {
        return $this->getTimestamp() < $datetime->getTimestamp();
    }

    public function isAfter(DateTimeInterface $datetime): bool
    {
        return $this->getTimestamp() > $datetime->getTimestamp();
    }

    public function isBetween(DateTimeInterface $start, DateTimeInterface $end): bool
    {
        return $this->isAfter($start) && $this->isBefore($end);
    }
}

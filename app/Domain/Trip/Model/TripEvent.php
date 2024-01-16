<?php

namespace App\Domain\Trip\Model;

use App\Domain\Shared\Exception\MissingOwnershipException;
use App\Domain\Trip\Enum\TripEventEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Class TripEvent
 *
 * @package App\Domain\Trip\Model
 *
 * @property-read int $id
 * @property int $trip_id
 * @property TripEventEnum $type
 * @property array $data
 * @property int $distance
 * @property bool $is_processed
 * @property \Illuminate\Support\Carbon $timestamp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent whereTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent whereIsProcessed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent whereUpdatedAt($value)
 */
class TripEvent extends Model
{
    protected $primaryKey = '_id';

    protected $table = 'trip_events';

    protected $fillable = [
        'trip_id',
        'type',
        'timestamp',
        'distance',
        'data',
        'distance_in_km',
        'is_processed'
    ];

    protected $casts = [
        'data' => 'json',
        'type' => TripEventEnum::class,
        'distance' => 'integer',
        'timestamp' => 'datetime',
        'is_processed' => 'boolean'
    ];

    public function getData(): array
    {
        $data = $this->data;
        if (is_array($data)) {
            if (array_key_exists(0, $data) && is_string($data[0])) {
                $data = json_decode($data[0], true);
            }
        }

        return $data ?? [];
    }

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::creating(function ($tripEvent) {
            if ($tripEvent->trip_id === null) {
                throw new MissingOwnershipException('Trip id is required');
            }

            $tripEvent->is_processed = false;
        });

        static::saving(function ($tripEvent) {
            if ($tripEvent->distance !== null) {
                $tripEvent->is_processed = true;
            }
        });
    }

    public function isProcessed(): bool
    {
        return $this->is_processed;
    }

    /**
     * Get the trip that owns the event.
     *
     * @return BelongsTo
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}

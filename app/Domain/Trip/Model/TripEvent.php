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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent query()
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripEvent whereType($value)
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
        'data'
    ];

    protected $casts = [
        'data' => 'array',
        'type' => TripEventEnum::class,
        'timestamp' => 'datetime'
    ];

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::creating(function ($tripEvent) {
            if ($tripEvent->trip_id === null) {
                throw new MissingOwnershipException('Trip id is required');
            }
        });
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

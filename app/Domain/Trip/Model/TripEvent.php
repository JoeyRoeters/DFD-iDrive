<?php

namespace App\Domain\Trip\Model;

use App\Domain\Trip\Enum\TripEventTypeEnum;
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
 * @property string $type
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
    protected $fillable = [
        'trip_id',
        'type',
    ];

    protected $casts = [
        'data' => 'array',
        'type' => TripEventTypeEnum::class,
    ];

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

<?php

namespace App\Domain\Trip\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

use Carbon\Carbon;
/**
 * Class TripData
 *
 * @package App\Domain\Trip\Model
 *
 * @property-read int $id
 * @property int $trip_id
 * @property array $accelero
 * @property array $gyroscope
 * @property float $speed
 * @property \Illuminate\Support\Carbon $time
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TripData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TripData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TripData query()
 * @method static \Illuminate\Database\Eloquent\Builder|TripData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripData whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripData whereAccelero($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripData whereGyroscope($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripData whereSpeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripData whereUpdatedAt($value)
 */
class TripData extends Model
{
    protected $fillable = [
        'trip_id',
        'accelero',
        'gyroscope',
        'speed',
        'time'
    ];

    protected $casts = [
        'accelero' => 'array',
        'gyroscope' => 'array',
        'speed' => 'float',
        'time' => 'datetime'
    ];

    /**
     * Get the trip that owns the data.
     *
     * @return BelongsTo
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }


    public function getTimestampAttribute($value)
    {
        return Carbon::createFromTimestamp($value->toDateTime()->getTimestamp())->toDateTimeString();
    }

}

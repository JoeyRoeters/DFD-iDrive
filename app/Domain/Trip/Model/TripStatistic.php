<?php

namespace App\Domain\Trip\Model;

use App\Domain\Trip\Enum\TripStatisticParserEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

/**
 * Class TripStatistic
 *
 * @package App\Domain\Trip\Model
 *
 * @property-read int $id
 * @property int $trip_id
 * @property string $parser
 * @property array $data
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|TripStatistic newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TripStatistic newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TripStatistic query()
 * @method static \Illuminate\Database\Eloquent\Builder|TripStatistic whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripStatistic whereTripId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripStatistic whereParser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripStatistic whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripStatistic whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TripStatistic whereUpdatedAt($value)
 */
class TripStatistic extends Model
{
    protected $fillable = [
        'trip_id',
        'parser',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
        'parser' => TripStatisticParserEnum::class,
    ];

    /**
     * Get the trip that owns the statistics.
     *
     * @return BelongsTo
     */
    public function trip(): BelongsTo
    {
        return $this->belongsTo(Trip::class);
    }
}

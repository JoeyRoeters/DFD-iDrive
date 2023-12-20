<?php

namespace App\Domain\Trip\Model;

use App\Domain\Shared\Interface\SearchableModelInterface;
use App\Domain\Trip\Enum\TripStateEnum;
use App\Domain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Relations\HasOne;

/**
 * Class Trip
 *
 * @property int $id
 * @property int $trip_number
 * @property string $user_id
 * @property string $device_id
 * @property TripStateEnum $state
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property float $distance
 * @property double $score
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip query()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip where()
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereTripNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereDeviceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereDistance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereUpdatedAt($value)
 */
class Trip extends Model implements SearchableModelInterface
{
    use HasFactory;

    protected $fillable = [
        'trip_number',
        'user_id',
        'device_id',
        'state',
        'start_time',
        'end_time',
        'distance',
        'score',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'trip_number' => 'integer',
        'user_id' => 'string',
        'device_id' => 'string',
        'state' => TripStateEnum::class,
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'distance' => 'float',
        'score' => 'double',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::creating(function ($trip) {
            $trip->state = TripStateEnum::IN_PROGRESS;
            $trip->start_time = Carbon::now();
        });
    }

    public static function getSearchableFields(): array
    {
        return [
            'trip_number',
            'user_id',
            'device_id',
        ];
    }


    public function getTimeFormatted(): string
    {
        return ($this->start_time ? $this->start_time->format('H:i') : '') . ' - ' . ($this->end_time ? $this->end_time->format('H:i') : '');
    }

    public function getDistanceFormatted(): string
    {
        return $this?->distance . ' km' ?? '';
    }

    public function getDateFormatted(): string
    {
        return $this->start_time?->format('d-m-Y') ?? '';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(TripEvent::class);
    }

    public function data(): HasMany
    {
        return $this->hasMany(TripData::class);
    }

    public function statistics(): HasMany
    {
        return $this->hasMany(TripStatistics::class);
    }

    public function hasAccess(User $user): bool
    {
        return $this->user_id === $user->id;
    }
}

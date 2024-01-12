<?php

namespace App\Domain\Trip\Model;

use App\Domain\Device\Model\Device;
use App\Domain\Shared\Exception\MissingOwnershipException;
use App\Domain\Shared\Interface\SearchableModelInterface;
use App\Domain\Shared\Interface\SearchableModelStringInterface;
use App\Domain\Trip\Enum\TripStateEnum;
use App\Domain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use MongoDB\BSON\Decimal128;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;
use MongoDB\Laravel\Relations\HasOne;

/**
 * Class Trip
 *
 * @property int $id
 * @property int $number
 * @property string $user_id
 * @property string $device_id
 * @property TripStateEnum $state
 * @property Carbon $start_time
 * @property Carbon $end_time
 * @property float $distance
 * @property double $score
 * @property string $search
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
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereSearch($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Trip whereUpdatedAt($value)
 */
class Trip extends Model implements SearchableModelStringInterface
{
    use HasFactory;

    protected $primaryKey = '_id';

    protected $fillable = [
        'number',
        'user_id',
        'device_id',
        'state',
        'start_time',
        'end_time',
        'distance',
        'score',
        'created_at',
        'updated_at',
        'search'
    ];

    protected $casts = [
        'number' => 'integer',
        'user_id' => 'string',
        'device_id' => 'string',
        'state' => TripStateEnum::class,
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'score' => 'double',
        'search' => 'string',
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

            if ($trip->user_id === null) {
                throw new MissingOwnershipException('User id is required');
            }

            if ($trip->device_id === null) {
                throw new MissingOwnershipException('Device id is required');
            }

            $trip->number = self::whereUserId($trip->user_id)->count() + 1;
        });

        // always append before save
        static::saving(function ($trip) {
            $trip->search = $trip->getSearchableString();
        });
    }

    public function getSearchableString(): string
    {
        $parts = [
            $this->getDeviceName(),
            $this->getDateFormatted(),
            $this->getTimeFormatted(),
            $this->getDistanceFormatted(),
            $this->getScoreFormatted(),
        ];

        return Str::lower(implode(' ', $parts));
    }


    public function getTimeFormatted(): string
    {
        return sprintf(
            '%s - %s',
            $this->start_time?->format('H:i') ?? 'N/A',
            $this->end_time?->format('H:i') ?? 'N/A'
        );
    }

    public function getDeviceName(): string
    {
        $device = $this->device;
        if (!$device) {
            return 'Unknown';
        }

        if (!empty($device->name)) {
            return $device->name;
        }

        return (string) $device->number ?? 'Unknown';
    }

    public function getDistanceFormatted(): string
    {
        $distance = $this->distance;
        if ($distance === null) {
            return 'N/A';
        }

        if ($distance instanceof Decimal128) {
            $distance = (float) $distance->jsonSerialize()['$numberDecimal'];
        }

        return round($distance, 2) . ' km';
    }

    public function getScoreFormatted(): string
    {
        if ($this->score === null) {
            return 'N/A';
        }

        return round($this->score / 10, 1);
    }

    public function getNumberFormatted(): string
    {
        return sprintf('%04d', $this->number);
    }


    public function getDateFormatted(): string
    {
        return $this->start_time?->format('d-m-Y') ?? 'N/A';
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
        return $this->hasMany(TripStatistic::class);
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function hasAccess(User $user): bool
    {
        return $this->user_id === $user->id;
    }
}

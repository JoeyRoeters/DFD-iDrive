<?php

namespace App\Domain\Device\Model;

use App\Domain\Device\Enum\DeviceTypeEnum;
use App\Domain\Shared\Exception\MissingOwnershipException;
use App\Domain\Shared\Interface\SearchableModelInterface;
use App\Domain\Trip\Enum\TripStateEnum;
use App\Domain\Trip\Model\Trip;
use App\Domain\User\Model\User;
use Carbon\Carbon;
use MongoDB\BSON\Decimal128;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;

/**
 * Class Device
 *
 * @property int $id
 * @property string $user_id
 * @property string $name
 * @property DeviceTypeEnum $type
 * @property Carbon $lastActive
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Device newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Device query()
 * @method static \Illuminate\Database\Eloquent\Builder|Device where()
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Device whereUpdatedAt($value)
 */
class Device extends Model implements SearchableModelInterface
{
    protected $primaryKey = '_id';

    protected $fillable = [
        'user_id',
        'number',
        'name',
        'type',
        'lastActive',
        'created_at',
        'updated_at'
    ];


    protected $casts = [
        'user_id' => 'string',
        'number' => 'int',
        'name' => 'string',
        'type' => DeviceTypeEnum::class,
        'lastActive' => 'datetime',
    ];

    public static function getSearchableFields(): array
    {
        return [
            'user_id',
            'name',
            'type',
            'lastActive',
        ];
    }

    /**
     * Boot the model.
     */
    protected static function booted()
    {
        static::creating(function ($device) {
            if ($device->user_id === null) {
                throw new MissingOwnershipException('User id is required');
            }

            $device->number = Device::whereUserId($device->user_id)->count() + 1;
        });
    }

    public function getDateFormatted(): string
    {
        return $this->lastActive?->format('d.m.Y') ?? '';
    }

    public function getLastActiveFormatted(): string
    {
        if (!$this->isSetup()) {
            return 'not been setup yet';
        }

        return sprintf(
            "last seen on %s at %s",
            $this->lastActive->format('d.m.Y'),
            $this->lastActive->format('H:i')
        );
    }

    public function isSetup(): bool
    {
        return $this->lastActive !== null;
    }

    public function getTimeFormatted(): string
    {
        return $this->lastActive?->format('H:i') ?? '';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function trips(): HasMany
    {
        return $this->hasMany(Trip::class);
    }

    public function hasAccess(?User $user): bool
    {
        return $this->user_id === $user?->id;
    }

    public function isCar(): bool
    {
        return $this->type === DeviceTypeEnum::COMMA3X;
    }

    public function isSimulator(): bool
    {
        return $this->type === DeviceTypeEnum::SIMULATOR;
    }

    public function getTotalTrips(): int
    {
        return $this->trips()
            ->where('state', TripStateEnum::FINISHED)
            ->count();
    }

    public function getTotalKilometers(): string
    {
        $total = $this->trips()
            ->where('state', TripStateEnum::FINISHED)
            ->sum('distance');

        if ($total === null) {
            return 'N/A';
        }

        if ($total instanceof Decimal128) {
            $total = (float) $total->__toString();
        }

        // return $total in string with max 2 decimals
        return number_format($total, 2);
    }
}

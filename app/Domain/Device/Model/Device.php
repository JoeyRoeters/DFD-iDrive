<?php

namespace App\Domain\Device\Model;

use App\Domain\Device\Enum\DeviceTypeEnum;
use App\Domain\Shared\Interface\SearchableModelInterface;
use App\Domain\Trip\Model\Trip;
use App\Domain\User\Model\User;
use Carbon\Carbon;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;
use MongoDB\Laravel\Relations\HasMany;

/**
 * Class Device
 *
 * @property int $id
 * @property string $user_id
 * @property string $name
 * @property string $type
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
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'lastActive',
        'created_at',
        'updated_at'
    ];


    protected $casts = [
        'user_id' => 'string',
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

    public function getDateFormatted(): string
    {
        return $this->lastActive?->format('d.m.Y') ?? '';
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
        return $this->hasMany(Trip::class, 'user_id', 'user_id');
    }

    public function hasAccess(?User $user): bool
    {
        return $this->user_id === $user?->id;
    }
}

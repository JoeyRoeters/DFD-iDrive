<?php

namespace App\Domain\Device\Model;

use App\Domain\Shared\Interface\SearchableModelInterface;
use App\Domain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

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
        'type' => 'string',
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
}

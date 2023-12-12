<?php

namespace App\Domain\Device\Model;

use App\Domain\Shared\Interface\SearchableModelInterface;
use App\Domain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Validation\Rules\Enum;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Class Device
 *
 * @property int $id
 * @property string $user_id
 * @property string $name
 * @property TypeEnum $type
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

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = TypeEnum::getValue($value);
    }

    public function getTypeAttribute($value)
    {
        return TypeEnum::getDescription($value);
    }

    protected $casts = [
        'user_id' => 'string',
        'name' => 'string',
        'type' => TypeEnum::class,
        'lastActive' => 'datetime',
    ];

    public static function getSearchableFields(): array
    {
        return [
            'user_id',
            'name',
            'lastActive',
        ];
    }

    public function getDateFormatted(): string
    {
        return $this->lastActive?->format('d.m.Y') ?? '';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


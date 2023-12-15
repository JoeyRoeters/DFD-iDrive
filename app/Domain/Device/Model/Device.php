<?php

namespace App\Domain\Device\Model;

use App\Domain\User\Model\User;
use MongoDB\Laravel\Eloquent\Model;
use MongoDB\Laravel\Relations\BelongsTo;

class Device extends Model
{
    protected $primaryKey = '_id';

    protected $fillable = [
        '_id',
        'user_id',
    ];

    /**
     * Get the user that owns the device.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

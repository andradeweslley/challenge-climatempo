<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $tokenable_type
 * @property int $tokenable_id
 * @property string $name
 * @property string $token
 * @property string|null $abilities
 * @property \Carbon\Carbon|null $last_used_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class PersonalAccessToken extends Model
{
    public static $snakeAttributes = false;
    protected $table = 'personal_access_tokens';

    protected $casts = [
        'tokenable_id' => 'int',
    ];

    protected $dates = [
        'last_used_at',
    ];

    protected $hidden = [
        'tokenable_id',
        'token',
    ];

    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
    ];
}

<?php

namespace App\Models;

use App\Search\Searchable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $state
 * @property string $latitude
 * @property string $longitude
 *
 * @property \Illuminate\Database\Eloquent\Collection|array<\App\Models\Weather> $weather
 */
class Locale extends Model
{
    use Searchable;

    public $timestamps = false;
    public static $snakeAttributes = false;
    protected $table = 'locales';

    protected $fillable = [
        'name',
        'state',
        'latitude',
        'longitude',
    ];

    /**
     * Relation with weather
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\Weather>
     */
    public function weather()
    {
        return $this->hasMany(Weather::class);
    }
}

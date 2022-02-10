<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $locale_id
 * @property \Carbon\Carbon $date
 * @property string $text
 * @property int $temperature_min
 * @property int $temperature_max
 * @property int $rain_probability
 * @property int $rain_precipitation
 *
 * @property \App\Models\Locale $locale
 */
class Weather extends Model
{
    public $timestamps = false;
    public static $snakeAttributes = false;
    protected $table = 'weather';

    protected $casts = [
        'locale_id' => 'int',
        'temperature_min' => 'int',
        'temperature_max' => 'int',
        'rain_probability' => 'int',
        'rain_precipitation' => 'int',
    ];

    protected $dates = [
        'date' => 'Y-m-d',
    ];

    protected $hidden = [
        'locale_id',
    ];

    protected $fillable = [
        'locale_id',
        'date',
        'text',
        'temperature_min',
        'temperature_max',
        'rain_probability',
        'rain_precipitation',
    ];

    /**
     * Relation with Locales
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function locale()
    {
        return $this->belongsTo(Locale::class);
    }
}

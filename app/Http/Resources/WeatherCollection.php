<?php

namespace App\Http\Resources;

use App\Models\Locale;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WeatherCollection extends ResourceCollection
{
    /** @var \App\Models\Locale|\Illuminate\Database\Eloquent\Collection<\App\Models\Locale> */
    private $locale;

    /** @var array */
    private $period;

    /**
     * Builds collection
     *
     * @param mixed $resource Resource itself
     * @param \App\Models\Locale|\Illuminate\Database\Eloquent\Collection<\App\Models\Locale> $locale   Locale data
     * @param array $period Date range to search
     */
    public function __construct($resource, Locale|\Illuminate\Database\Eloquent\Collection $locale, array $period)
    {
        parent::__construct($resource);

        $this->locale = $locale;
        $this->period = $period;
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'period' => $this->period,
            'locale' => new LocaleResource($this->locale),
            'weather' => $this->collection,
        ];
    }
}

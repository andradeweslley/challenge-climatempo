<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'date' => $this->date,
            'text' => $this->text,
            'temperature' => [
                'min' => $this->temperature_min,
                'max' => $this->temperature_max,
            ],
            'rain' => [
                'probability' => $this->rain_probability,
                'precipitation' => $this->rain_precipitation,
            ],
        ];
    }
}

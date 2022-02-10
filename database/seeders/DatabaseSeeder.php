<?php

namespace Database\Seeders;

use App\Models\Locale;
use App\Models\Weather;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve data from json
        $allData = json_decode(Storage::disk('base')->get('weather.json'), true);

        if (empty($allData) || !is_array($allData)) {
            return;
        }

        foreach ($allData as $data) {
            // Retrieve data from locale and adds in table
            $locale = $this->storeLocale($data['locale']);

            if (empty($data['weather']) || !is_array($data['weather'])) {
                continue;
            }

            foreach ($data['weather'] as $weatherData) {
                // Retrieve data from weather and adds in table
                $this->storeWeather($weatherData, $locale->id);
            }
        }
    }

    /**
     * Save locale into database
     *
     * @param array $data Data of locale to be saved
     *
     * @return \App\Models\Locale|\Illuminate\Database\Eloquent\Collection<\App\Models\Locale>
     */
    private function storeLocale(array $data)
    {
        $locale = Locale::find($data['id']);

        if (!$locale) {
            $locale = new Locale();

            $locale->id = $data['id'];
            $locale->name = $data['name'];
            $locale->state = $data['state'];
            $locale->latitude = $data['latitude'];
            $locale->longitude = $data['longitude'];

            $locale->save();
        }

        return $locale;
    }

    /**
     * Save weather into database
     *
     * @param array $data Data of weather to be saved
     *
     * @return void
     */
    private function storeWeather(array $data, int $localeId)
    {
        $weather = Weather::where([
            'locale_id' => $localeId,
            'date' => $data['date'],
        ])->first();

        $weather = new Weather();

        $weather->locale_id = $localeId;
        $weather->date = $data['date'];
        $weather->text = $data['text'];
        $weather->temperature_min = $data['temperature']['min'];
        $weather->temperature_max = $data['temperature']['max'];
        $weather->rain_probability = $data['rain']['probability'];
        $weather->rain_precipitation = $data['rain']['precipitation'];

        $weather->save();
    }
}

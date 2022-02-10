<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeatherRequest;
use App\Http\Resources\WeatherCollection;
use App\Models\Locale;
use App\Models\Weather;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \App\Http\Resources\WeatherCollection|\Illuminate\Http\JsonResponse
     */
    public function index(WeatherRequest $request)
    {
        // Encontra primeiro a localidade
        $locale = Locale::find($request->get('locale'));

        if (!$locale) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'Localidade não encontrada',
            ], 404);
        }

        // Coloca o período em uma variável para melhor trativa
        $period = $request->input('period', [
            'begin' => '2017-02-01', 
            'end' => '2017-02-07',
        ]);

        // Encontra a previsão para o período solicitado
        $weather = Weather::where('locale_id', $locale->id)
            ->whereBetween('date', [$period['begin'], $period['end']])
            ->get();

        return new WeatherCollection($weather, $locale, $period);
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WeatherRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'period' => 'array',
            'period.begin' => 'date_format:Y-m-d',
            'period.end' => 'date_format:Y-m-d',

            'locale' => 'required|integer',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'period.required' => 'Período não informado',

            'period.begin.required' => 'Data inicial de pesquisa não informado',
            'period.begin.date_format' => 'Data inicial no formato inválido. Informe como AAAA-MM-DD.',

            'period.end.required' => 'Data final de pesquisa não informado',
            'period.end.date_format' => 'Data final no formato inválido. Informe como AAAA-MM-DD.',

            'locale.required' => 'Localidade não informado',
            'locale.integer' => 'Localidade deve conter apenas números',
        ];
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocaleResource;
use App\Models\Locale;
use App\Repository\SearchRepository;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(SearchRepository $searchRepository, Request $request)
    {
        $locales = $request->has('q') && !empty($request->get('q'))
            ? $searchRepository->search(strtolower($request->get('q')))
            : Locale::all();

        return LocaleResource::collection($locales);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \App\Http\Resources\LocaleResource
     */
    public function show($id)
    {
        $locale = Locale::findOrFail($id);

        return new LocaleResource($locale);
    }
}

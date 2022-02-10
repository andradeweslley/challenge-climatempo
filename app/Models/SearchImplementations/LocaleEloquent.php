<?php

namespace App\Models\SearchImplementations;

use App\Models\Locale;
use App\Repository\SearchRepository;
use Illuminate\Database\Eloquent\Collection;

class LocaleEloquent implements SearchRepository
{
    public function search(string $term): Collection
    {
        return Locale::where('name', 'LIKE', "%{$term}%")
            ->get();
    }
}

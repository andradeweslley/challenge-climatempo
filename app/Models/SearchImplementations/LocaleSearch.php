<?php

namespace App\Models\SearchImplementations;

use App\Models\Locale;
use App\Repository\SearchRepository;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class LocaleSearch implements SearchRepository
{
    /** @var \Elasticsearch\Client */
    private $elasticSearch;

    public function __construct(Client $elasticSearch)
    {
        $this->elasticSearch = $elasticSearch;
    }

    public function search(string $query = ''): Collection
    {
        $items = $this->searchOnElasticsearch($query);

        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch(string $query = ''): array
    {
        $model = new Locale();

        $query = trim(str_replace(' ', ' ', $query));

        return $this->elasticSearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'fields' => ['name'],
                        'query' => "\"$query\"",
                        // 'query' => "$query*",
                    ],
                    // 'prefix' => [
                    //     'name' => "\"$query\"",
                    // ],
                ],
            ],
        ]);
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Locale::findMany($ids)
            ->sortBy(function ($locale) use ($ids) {
                return array_search($locale->getKey(), $ids);
            });
    }
}

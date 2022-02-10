<?php

namespace App\Providers;

use App\Models\SearchImplementations\LocaleEloquent;
use App\Models\SearchImplementations\LocaleSearch;
use App\Repository\SearchRepository;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(SearchRepository::class, LocaleEloquent::class);

        $this->app->bind(SearchRepository::class, function ($app) {
            // This is useful in case we want to turn-off our
            // search cluster or when deploying the search
            // to a live, running application at first.
            if (!config('services.search.enabled')) {
                return new LocaleEloquent();
            }

            return new LocaleSearch(
                $app->make(Client::class)
            );
        });

        $this->bindSearchClient();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        JsonResource::withoutWrapping();
    }

    /**
     * Bind Elasticsearch\ClientBuilder to Elasticsearch\Client
     *
     * @return void
     */
    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
    }
}

<?php

namespace App\Providers;

use App\Repositories\ArticlesRepositoryInterface;
use App\Repositories\ElasticSearchRepository;
use App\Repositories\EloquentRepository;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ArticlesRepositoryInterface::class, function () {
            // Это полезно, если мы хотим выключить наш кластер
            // или при развертывании поиска на продакшене
            if (! config('services.search.enabled')) {
                return new EloquentRepository();
            }
            return new ElasticSearchRepository(
                app()->make(Client::class)
            );
        });

        $this->bindSearchClient();

        //$this->app->bind(ArticlesRepositoryInterface::class, EloquentRepository::class);
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

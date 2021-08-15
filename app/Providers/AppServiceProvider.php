<?php

namespace App\Providers;

use App\Contract\ArticleRepository;
use App\Repository\ElasticSearchRepository;
use App\Repository\EloquentRepository;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
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
        $this->app->bind(
            ArticleRepository::class,
            function ($app) {

                if (config('app.elasticsearch.enabled')) {
                    return new ElasticSearchRepository($app->make(Client::class));
                }
                return new EloquentRepository();
            }
        );
        $this->bindSearchClient();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('app.elasticsearch.hosts'))
                ->build();
        });
    }
}

<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * @var string
     */
    protected $apiNamespace = 'App\Http\Api\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router, \Dingo\Api\Routing\Router $apiRouter)
    {
        $this->mapWebRoutes($router, $apiRouter);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router, \Dingo\Api\Routing\Router $apiRouter)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require base_path('routes/web.php');
        });

        $apiRouter->version('v1', [
            'namespace' => $this->apiNamespace, 'middleware' => ['web', 'api'],
        ], function ($api) {
            require base_path('routes/api.php');
        });
    }
}

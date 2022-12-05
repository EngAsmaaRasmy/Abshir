<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

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
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';
    public const ADMIN = '/admin/home';
    public const SHOP = "/shop/home";
    public const DRIVERSonMap = "/drivers-on-map/home";
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapDriversOnMapRoutes();
        $this->mapAdminRoutes();
        $this->mapShopRoutes();
        $this->mapWebRoutes();
        $this->mapDriverApiRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }
    protected function mapAdminRoutes()
    {
        Route::prefix("admin")
            ->middleware('admin')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }
    protected function mapDriversOnMapRoutes()
    {
        Route::prefix("drivers-on-map")
            ->middleware('drivers-on-map')
            ->namespace($this->namespace)
            ->group(base_path('routes/drivers-on-map.php'));
    }
    protected function mapShopRoutes()
    {
        Route::prefix("shop")
            ->middleware('shop')
            ->namespace($this->namespace . '\shop')
            ->group(base_path('routes/shop.php'));
    }


    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace . '\api')
            ->group(base_path('routes/api.php'));
    }
    protected function mapDriverApiRoutes()
    {
        Route::prefix('api/driver')
            ->namespace($this->namespace . '\api' . "\Driver")
            ->group(base_path('routes/driver-api.php'));
    }
}

<?php

namespace TRMS\Carousel;

use Illuminate\Support\ServiceProvider;

class CarouselServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
          __DIR__.'config/carousel.php' => config_path('carousel.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
      $this->mergeConfigFrom(
        __DIR__.'/config/carousel.php', 'carousel'
      );
    }
}

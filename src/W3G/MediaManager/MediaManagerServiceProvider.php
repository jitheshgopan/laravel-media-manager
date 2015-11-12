<?php
namespace W3G\MediaManager;

use Illuminate\Support\ServiceProvider;

class MediaManagerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot() {
        $configPath =   __DIR__ . '/../../config';
        $this->publishes([
            $configPath => config_path('laravel-media-manager')
        ], 'config');

        $this->publishes([
            __DIR__.'/../../../public' => public_path('packages/ahmadazimi/laravel-media-manager'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../../views' => base_path('resources/views/vendor/laravel-media-manager'),
        ], 'views');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		$this->app['command.mediamanager.publish'] = $this->app->share(function ($app) {
			//Make sure the asset publisher is registered.
			$app->register('Illuminate\Foundation\Providers\PublisherServiceProvider');
			
			return new Console\PublishCommand($app['asset.publisher']);
		});

		$this->commands('command.mediamanager.publish');
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return array(
			'command.mediamanager.publish',
		);
	}
}

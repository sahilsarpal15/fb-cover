<?php
namespace Acme\Repositories;
use Illuminate\Support\ServiceProvider;

class BackendServiceProvider extends ServiceProvider{
	public function register()
	{
		$this->app->bind(
			'Acme\Repositories\UserRepositoryInterface',
			'Acme\Repositories\UserRepository'
			);
		$this->app->bind(
			'Acme\Repositories\PageRepositoryInterface',
			'Acme\Repositories\PageRepository'
			);


	}
}
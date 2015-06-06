<?php namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider{
	
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot(){
		DB::listen(
			function($sql, $bindings, $time){
				#print '<font color="#ff0000" style="font-size: 30px">'.$time.' '.$sql.'</font>'; var_dump($bindings);
			}
		);
	}
	
	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register(){
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}
	
}

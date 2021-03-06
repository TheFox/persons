<?php

namespace App\Providers;

use DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		// Schema::defaultStringLength(191);
		
		// DB::listen(
		// 	function($sql, $bindings, $time){
		// 		print '<font color="#ff0000" style="font-size: 30px">'.$time.' '.$sql.'</font>';
		// 		var_dump($bindings);
		// 	}
		// );
	}
	
	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}
}

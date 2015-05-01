<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider {
	
	/**
	 * Overwrite any vendor / package configuration.
	 *
	 * This service provider is intended to provide a convenient location for you
	 * to overwrite any "vendor" or package configuration that you may want to
	 * modify before the application handles the incoming request / command.
	 *
	 * @return void
	 */
	public function register(){
		config(array(
			'twigbridge' => array(
				'extensions' => array(
					'enabled' => array(
						'TwigBridge\Extension\Loader\Facades',
						'TwigBridge\Extension\Loader\Filters',
						'TwigBridge\Extension\Loader\Functions',
						'TwigBridge\Extension\Laravel\Auth',
						'TwigBridge\Extension\Laravel\Config',
						'TwigBridge\Extension\Laravel\Input',
						'TwigBridge\Extension\Laravel\Session',
						'TwigBridge\Extension\Laravel\String',
						'TwigBridge\Extension\Laravel\Translator',
						'TwigBridge\Extension\Laravel\Url',
						
						#'TwigBridge\Extension\Laravel\Form',
						'TwigBridge\Extension\Laravel\Html',
					),
					'facades' => array(
					),
					'functions' => array(
						'dd',
					),
				),
				
			),
		));
	}
	
}

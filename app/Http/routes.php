<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', array('as' => 'index', 'uses' => 'WelcomeController@index'));

Route::get('home', array('as' => 'home', 'uses' => 'HomeController@index'));

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(array('middleware' => 'auth'), function(){
	Route::get('persons/{page?}', array('as' => 'person.list', 'uses' => 'PersonController@index'));
	
	Route::group(array('prefix' => 'person'), function(){
		Route::get('create', array('as' => 'person.create', 'uses' => 'PersonController@create'));
		Route::post('store', array('as' => 'person.store', 'uses' => 'PersonController@store'));
		
		Route::get('edit/{id}', array('as' => 'person.edit', 'uses' => 'PersonController@edit'));
		Route::post('update/{id}', array('as' => 'person.update', 'uses' => 'PersonController@update'));
		
		Route::get('delete/{id}', array('as' => 'person.delete', 'uses' => 'PersonController@delete'));
		Route::get('destroy/{id}', array('as' => 'person.destroy', 'uses' => 'PersonController@destroy'));
		
		Route::get('show/{id}', array('as' => 'person.show', 'uses' => 'PersonController@show'));
		
		Route::get('search', array('as' => 'person.search.input', 'uses' => 'PersonController@searchInput'));
		Route::post('search/show', array('as' => 'person.search.output', 'uses' => 'PersonController@searchOutput'));
		
		Route::group(array('prefix' => 'event'), function(){
			Route::get('create/{id}', array('as' => 'person.event.create', 'uses' => 'PersonEventController@create'));
			Route::post('store/{id}', array('as' => 'person.event.store', 'uses' => 'PersonEventController@store'));
			
			Route::get('edit/{id}', array('as' => 'person.event.edit', 'uses' => 'PersonEventController@edit'));
			Route::post('update/{id}', array('as' => 'person.event.update', 'uses' => 'PersonEventController@update'));
			
			Route::get('show/{id}', array('as' => 'person.event.show', 'uses' => 'PersonEventController@show'));
			
			Route::get('delete/{id}', array('as' => 'person.event.delete', 'uses' => 'PersonEventController@delete'));
			Route::get('destroy/{id}', array('as' => 'person.event.destroy', 'uses' => 'PersonEventController@destroy'));
		});
	});
});

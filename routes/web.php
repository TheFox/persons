<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['as' => 'index', 'uses' => 'WelcomeController@index']);

Auth::routes();
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::get('home', ['as' => 'home', 'uses' => 'HomeController@index']);
// Route::get('/home', 'HomeController@index');

Route::get('persons/{page?}', ['as' => 'person.list', 'uses' => 'PersonController@index']);

Route::group(['prefix' => 'person'], function(){
	Route::get('create', ['as' => 'person.create', 'uses' => 'PersonController@create']);
	Route::get('create/quick', ['as' => 'person.create.quick', 'uses' => 'PersonController@quickCreate']);
	Route::post('store', ['as' => 'person.store', 'uses' => 'PersonController@store']);
	
	Route::get('edit/{id}', ['as' => 'person.edit', 'uses' => 'PersonController@edit']);
	Route::post('update/{id}', ['as' => 'person.update', 'uses' => 'PersonController@update']);
	
	Route::get('delete/{id}', ['as' => 'person.delete', 'uses' => 'PersonController@delete']);
	Route::get('destroy/{id}', ['as' => 'person.destroy', 'uses' => 'PersonController@destroy']);
	
	Route::get('show/{id}', ['as' => 'person.show', 'uses' => 'PersonController@show']);
	
	Route::get('search', ['as' => 'person.search.input', 'uses' => 'PersonController@searchInput']);
	Route::post('search/show', ['as' => 'person.search.output', 'uses' => 'PersonController@searchOutput']);
	
	Route::group(['prefix' => 'event'], function(){
		Route::get('create/{id}', ['as' => 'person.event.create', 'uses' => 'PersonEventController@create']);
		Route::post('store/{id}', ['as' => 'person.event.store', 'uses' => 'PersonEventController@store']);
		
		Route::get('edit/{id}', ['as' => 'person.event.edit', 'uses' => 'PersonEventController@edit']);
		Route::post('update/{id}', ['as' => 'person.event.update', 'uses' => 'PersonEventController@update']);
		
		Route::get('show/{id}', ['as' => 'person.event.show', 'uses' => 'PersonEventController@show']);
		
		Route::get('delete/{id}', ['as' => 'person.event.delete', 'uses' => 'PersonEventController@delete']);
		Route::get('destroy/{id}', ['as' => 'person.event.destroy', 'uses' => 'PersonEventController@destroy']);
	});
});

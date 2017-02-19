<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
		'last_login',
		'deleted_at',
	];
	
	protected $dates = [
		#'last_login',
		'deleted_at',
	];
	
	public function persons(){
		return $this
			->hasMany('App\Person')
			->notDeleted();
	}
	
	public function personEvents(){
		return $this
			->hasMany('App\PersonEvent')
			->notDeleted();
	}
	
	public function scopeNotDeleted($query){
		return $query
			->whereNull('deleted_at');
	}
	
}

<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract{
	
	use Authenticatable, CanResetPassword;
	
	protected $table = 'users';
	
	protected $fillable = array('name', 'email', 'password');
	
	protected $hidden = array(
		'password',
		'remember_token',
		'last_login',
		'deleted_at',
	);
	
	public function persons(){
		return $this->hasMany('App\Person');
	}
	
	public function personEvents(){
		return $this->hasMany('App\PersonEvent');
	}
	
}

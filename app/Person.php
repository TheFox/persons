<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model{
	
	protected $table = 'persons';
	
	protected $fillable = array(
		'last_name',
		'last_name_born',
		'middle_name',
		'first_name',
		'nick_name',
		'birthday',
		'deceased_at',
		'first_met_at',
		'facebook_id',
		'blood_type',
		'blood_type_rhd',
		'default_event_type',
		'comment',
	);
	
	protected $hidden = array('deleted_at');
	
	protected $dates = array('birthday', 'deceased_at', 'first_met_at');
	
	public function user(){
		return $this->belongsTo('App\User');
	}
	
	public function events(){
		return $this->hasMany('App\PersonEvent');
	}
	
	public function isOwn($user){
		if($user && !$user->deleted_at && $this->user_id == $user->id){
			return true;
		}
		
		return false;
	}
	
	public function userHasPermissionRead($user){
		if(!$this->deleted_at && $this->isOwn($user)){
			return true;
		}
		
		return false;
	}
	
	public function userHasPermissionWrite($user){
		if(!$this->deleted_at && $this->isOwn($user)){
			return true;
		}
		
		return false;
	}
	
	public function updateName(){
		$name = array();
		if($this->last_name){
			$name[] = $this->last_name;
		}
		if($this->first_name){
			$name[] = $this->first_name;
		}
		$this->name = join(' ', $name);
	}
	
}

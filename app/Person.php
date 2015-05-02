<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model{
	
	protected $table = 'persons';
	
	protected $fillable = array('last_name', 'last_name_born', 'middle_name', 'first_name', 'nick_name', 'birthday', 'deceased_at', 'first_met_at', 'facebook_id', 'comment');
	
	protected $hidden = array('deleted_at');
	
	public function user(){
		return $this->belongsTo('App\User');
	}
	
	public function userHasPermissionRead($user){
		$userId = 0;
		
		if($user && !$user->deleted_at){
			$userId = $user->id;
		}
		
		if(!$this->deleted_at && $this->user_id == $userId){
			return true;
		}
		
		return false;
	}
	
	public function userHasPermissionWrite($user){
		$userId = 0;
		
		if($user && !$user->deleted_at){
			$userId = $user->id;
		}
		
		if(!$this->deleted_at && $this->user_id == $userId){
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
		$this->save();
	}
	
}

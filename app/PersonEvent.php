<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonEvent extends Model{
	
	public static $EVENT_TYPES = array(
		1000 => 'Info',
		2000 => 'Said',
		2300 => 'Text/IM',
		3000 => 'Done',
	);
	
	protected $table = 'person_events';
	
	protected $fillable = array(
		'user_id',
		'person_id',
		'happened_at',
		'type',
		'place',
		'title',
		'comment',
	);
	
	protected $hidden = array('deleted_at');
	
	protected $touches = array('person');
	
	public function user(){
		return $this
			->belongsTo('App\User')
			->notDeleted();
	}
	
	public function person(){
		return $this
			->belongsTo('App\Person')
			->notDeleted();
	}
	
	public function scopeNotDeleted($query){
		return $query
			->whereNull('deleted_at');
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
	
}

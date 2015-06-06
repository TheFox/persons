<?php namespace App\Http\Requests\Person\Event;

use Auth;

use App\Http\Requests\BaseRequest;
use App\PersonEvent;

class WriteRequest extends BaseRequest{
	
	public $event;
	
	public function authorize(){
		$auth = false;
		
		$user = Auth::user();
		$id = $this->route('id');
		$this->event = PersonEvent::find($id);
		
		if($this->event && $this->event->userHasPermissionWrite($user)){
			$person = $this->event->person;
			
			if($person && $person->userHasPermissionWrite($user)){
				$auth = true;
			}
		}
		
		return $auth;
	}
	
}

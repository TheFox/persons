<?php namespace App\Http\Requests\Person\Event;

use Auth;

use App\PersonEvent;

class UpdateRequest extends SaveRequest{
	
	public $event;
	
	public function authorize(){
		$auth = false;
		
		$user = Auth::user();
		$id = $this->route('id');
		$this->event = PersonEvent::
			notDeleted()
			->find($id);
		
		if($this->event && $this->event->userHasPermissionWrite($user)){
			$person = $this->event->person;
			
			if($person && $person->userHasPermissionWrite($user)){
				$auth = true;
			}
		}
		
		return $auth;
	}
	
}

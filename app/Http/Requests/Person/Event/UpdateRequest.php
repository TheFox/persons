<?php namespace App\Http\Requests\Person\Event;

use Auth;

use App\PersonEvent;

class UpdateRequest extends SaveRequest{
	
	public function authorize(){
		$auth = false;
		
		$user = Auth::user();
		$id = $this->route('id');
		$event = PersonEvent::find($id);
		
		if($event && $event->userHasPermissionWrite($user)){
			$person = $event->person;
			
			if($person && $person->userHasPermissionWrite($user)){
				$auth = true;
			}
		}
		
		return $auth;
	}
	
}

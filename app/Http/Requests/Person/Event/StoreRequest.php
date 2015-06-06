<?php namespace App\Http\Requests\Person\Event;

use Auth;

use App\Person;
use App\PersonEvent;

class StoreRequest extends SaveRequest{
	
	public $person;
	
	public function authorize(){
		$auth = false;
		
		$id = $this->route('id');
		$this->person = Person::
			notDeleted()
			->find($id);
		
		if($this->person && $this->person->userHasPermissionWrite(Auth::user())){
			$auth = true;
		}
		
		return $auth;
	}
	
}

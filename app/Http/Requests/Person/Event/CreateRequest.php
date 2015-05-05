<?php namespace App\Http\Requests\Person\Event;

use Auth;

use App\Http\Requests\BaseRequest;
use App\Person;
use App\PersonEvent;

class CreateRequest extends BaseRequest{
	
	public function authorize(){
		$auth = false;
		
		$user = Auth::user();
		$id = $this->route('id');
		$person = Person::find($id);
		
		if($person && $person->userHasPermissionWrite($user)){
			$auth = true;
		}
		
		return $auth;
	}
	
}

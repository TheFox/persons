<?php namespace App\Http\Requests\Person;

use Auth;

use App\Person;

class UpdateRequest extends SaveRequest{
	
	public function authorize(){
		$auth = false;
		
		$id = $this->route('id');
		$person = Person::find($id);
		
		if($person && $person->userHasPermissionWrite(Auth::user())){
			$auth = true;
		}
		
		return $auth;
	}
	
}
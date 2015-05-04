<?php namespace App\Http\Requests\Person;

use Auth;

use App\Http\Requests\BaseRequest;
use App\Person;

class DeleteRequest extends BaseRequest{
	
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

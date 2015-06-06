<?php namespace App\Http\Requests\Person;

use Auth;

use App\Http\Requests\BaseRequest;
use App\Person;

class WriteRequest extends BaseRequest{
	
	public $person;
	
	public function authorize(){
		$auth = false;
		
		$id = $this->route('id');
		$this->person = Person::find($id);
		
		if($this->person && $this->person->userHasPermissionWrite(Auth::user())){
			$auth = true;
		}
		
		return $auth;
	}
	
}

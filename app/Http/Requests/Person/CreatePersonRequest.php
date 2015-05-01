<?php namespace App\Http\Requests\Person;

use App\Http\Requests\BaseRequest;

class CreatePersonRequest extends BaseRequest{
	
	public function authorize(){
		$auth = true;
		return $auth;
	}
	
}

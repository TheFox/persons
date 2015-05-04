<?php namespace App\Http\Requests\Person;

use App\Http\Requests\BaseRequest;

class CreateRequest extends BaseRequest{
	
	public function authorize(){
		$auth = true;
		return $auth;
	}
	
}

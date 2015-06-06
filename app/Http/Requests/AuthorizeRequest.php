<?php namespace App\Http\Requests;

class AuthorizeRequest extends BaseRequest{
	
	public function authorize(){
		return true;
	}
	
}

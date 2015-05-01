<?php namespace App\Http\Requests;

use View;
use Response;

class BaseRequest extends Request{
	
	public function forbiddenResponse(){
		return response(view('errors.403'), 403);
	}
	
	public function authorize(){
		return false;
	}
	
	public function rules(){
		return array(
			
		);
	}
	
}

<?php namespace App\Http\Requests\Person;

class StoreRequest extends SaveRequest{
	
	public function authorize(){
		return true;
	}
	
}

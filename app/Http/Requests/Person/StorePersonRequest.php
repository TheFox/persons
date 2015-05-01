<?php namespace App\Http\Requests\Person;

class StorePersonRequest extends SavePersonRequest{
	
	public function authorize(){
		return true;
	}
	
}

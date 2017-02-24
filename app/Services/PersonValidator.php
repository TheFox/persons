<?php

namespace App\Services;

use Auth;
use Log;
use Illuminate\Validation\Validator;
use App\Person;

class PersonValidator extends Validator{
	
	public function validateNameUnique($attribute, $value, $parameters){
		$user = Auth::user();
		$userId = 0;
		if($user){
			$userId = $user->id;
		}
		
		$attempt = (int)$this->data['attempt'];
		
		if($attempt >= 2){
			return true;
		}
		
		$personsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->where('last_name', 'like', $this->data['last_name'])
			->where('first_name', 'like', $this->data['first_name']);
		
		// Alternative name checking method.
		/*if($this->data['last_name']){
			$personsBuilder->where('last_name', 'like', $this->data['last_name']);
		}
		else{
			$personsBuilder->where('last_name', 'like', '');
		}
		
		if($this->data['first_name']){
			$personsBuilder->where('first_name', 'like', $this->data['first_name']);
		}
		else{
			$personsBuilder->where('first_name', 'like', '');
		}*/
		
		if($this->data['id']){
			$personsBuilder->where('id', '!=', $this->data['id']);
		}
		
		$oldPerson = $personsBuilder->first();
		if($oldPerson){
			$this->data['oldPerson'] = $oldPerson;
		}
		else{
			$this->data['oldPerson'] = null;
			return true;
		}
		
		return false;
	}
	
	protected function replaceNameUnique($message, $attribute, $rule, $parameters){
		$message = str_replace(':id', $this->data['oldPerson']->id, $message);
		$message = str_replace(':last_name', $this->data['oldPerson']->last_name, $message);
		$message = str_replace(':first_name', $this->data['oldPerson']->first_name, $message);
		
		return $message;
	}

}

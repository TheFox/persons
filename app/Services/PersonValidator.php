<?php

namespace App\Services;

use Illuminate\Validation\Validator;
use Auth;
use Log;

use App\Person;

class PersonValidator extends Validator{
	
	public function validateNameUnique($attribute, $value, $parameters){
		$valid = false;
		
		$user = Auth::user();
		$userId = 0;
		if($user){
			$userId = $user->id;
		}
		
		$personsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->where('last_name', 'like', $this->data['last_name'])
			->where('first_name', 'like', $this->data['first_name'])
			;
		
		if($this->data['id']){
			$personsBuilder->where('id', '!=', $this->data['id']);
		}
		
		$this->data['oldPerson'] = null;
		
		$oldPerson = $personsBuilder->first();
		if($oldPerson){
			$this->data['oldPerson'] = $oldPerson;
		}
		else{
			$valid = true;
		}
		
		return $valid;
	}
	
	protected function replaceNameUnique($message, $attribute, $rule, $parameters){
		$message = str_replace(':id', $this->data['oldPerson']->id, $message);
		$message = str_replace(':last_name', $this->data['oldPerson']->last_name, $message);
		$message = str_replace(':first_name', $this->data['oldPerson']->first_name, $message);
		return $message;
	}

}

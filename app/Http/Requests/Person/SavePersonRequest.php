<?php namespace App\Http\Requests\Person;

use App\Http\Requests\BaseRequest;

class SavePersonRequest extends BaseRequest{
	
	public function rules(){
		return array(
			'last_name' => 'string|min:1|max:255',
			'middle_name' => 'string|min:1|max:255',
			'first_name' => 'string|min:1|max:255',
			'nick_name' => 'string|min:1|max:255',
			'birthday_year' => 'numeric',
			'birthday_month' => 'numeric',
			'birthday_day' => 'numeric',
			'deceased_at_year' => 'numeric',
			'deceased_at_month' => 'numeric',
			'deceased_at_day' => 'numeric',
			'first_met_at_year' => 'numeric',
			'first_met_at_month' => 'numeric',
			'first_met_at_day' => 'numeric',
		);
	}
	
}

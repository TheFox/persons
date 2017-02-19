<?php

namespace App\Http\Requests\Person;

use App\Http\Requests\AuthorizeRequest;

class SearchOutputRequest extends AuthorizeRequest{
	
	public function rules(){
		return [
			'id' => 'nullable|numeric',
			'last_name' => 'nullable|string',
			'first_name' => 'nullable|string',
		];
	}
	
}

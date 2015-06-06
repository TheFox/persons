<?php namespace App\Http\Requests\Person;

use App\Http\Requests\AuthorizeRequest;

class SearchOutputRequest extends AuthorizeRequest{
	
	public function rules(){
		return array(
			'id' => 'numeric',
		);
	}
	
}

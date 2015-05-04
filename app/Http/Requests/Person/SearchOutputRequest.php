<?php namespace App\Http\Requests\Person;

use App\Http\Requests\BaseRequest;

class SearchOutputRequest extends BaseRequest{
	
	public function authorize(){
		return true;
	}
	
	public function rules(){
		return array(
			'id' => 'numeric',
		);
	}
	
}

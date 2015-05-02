<?php namespace App\Http\Requests\Person;

use DateTime;

use Illuminate\Validation\Factory;

use App\Http\Requests\BaseRequest;
use App\Services\PersonValidator;

class SavePersonRequest extends BaseRequest{
	
	public function rules(){
		return array(
			'last_name' => 'string|min:1|max:255|name_unique',
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
	
	public function input($key = null, $default = null){
		$input = parent::input($key, $default);
		
		switch($key){
			case 'birthday':
				$birthdayYear = (int)$this->input('birthday_year');
				$birthdayMonth = (int)$this->input('birthday_month');
				$birthdayDay = (int)$this->input('birthday_day');
				if($birthdayYear && $birthdayMonth && $birthdayDay){
					$birthday = new DateTime();
					$birthday->setDate($birthdayYear, $birthdayMonth, $birthdayDay);
					$input = $birthday->format('Y-m-d');
				}
				break;
			
			case 'deceased_at':
				$deceasedAtYear = (int)$this->input('deceased_at_year');
				$deceasedAtMonth = (int)$this->input('deceased_at_month');
				$deceasedAtDay = (int)$this->input('deceased_at_day');
				if($deceasedAtYear && $deceasedAtMonth && $deceasedAtDay){
					$deceasedAt = new DateTime();
					$deceasedAt->setDate($deceasedAtYear, $deceasedAtMonth, $deceasedAtDay);
					$input = $deceasedAt->format('Y-m-d');
				}
				break;
			
			case 'first_met_at':
				$firstMetAtYear = (int)$this->input('first_met_at_year');
				$firstMetAtMonth = (int)$this->input('first_met_at_month');
				$firstMetAtDay = (int)$this->input('first_met_at_day');
				if($firstMetAtYear && $firstMetAtMonth && $firstMetAtDay){
					$firstMetAt = new DateTime();
					$firstMetAt->setDate($firstMetAtYear, $firstMetAtMonth, $firstMetAtDay);
					$input = $firstMetAt->format('Y-m-d');
				}
				
				break;
			
			case 'birthday_year':
			case 'birthday_month':
			case 'birthday_day':
			case 'deceased_at_year':
			case 'deceased_at_month':
			case 'deceased_at_day':
			case 'first_met_at_year':
			case 'first_met_at_month':
			case 'first_met_at_day':
				// Do nothing and take original value.
				break;
			
			default:
				$input['birthday'] = $this->input('birthday');
				$input['deceased_at'] = $this->input('deceased_at');
				$input['first_met_at'] = $this->input('first_met_at');
				break;
		}
		
		return $input;
	}
	
	public function validator(Factory $factory){
		$id = $this->route('id');
		
		$factory->resolver(function($translator, $data, $rules, $messages) use($id){
			$data['id'] = $id;
			
			$validator = new PersonValidator($translator, $data, $rules, $messages);
			return $validator;
		});
		
		return $factory->make($this->input(), $this->container->call(array($this, 'rules')), $this->messages());
	}
	
}

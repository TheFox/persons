<?php namespace App\Http\Requests\Person;

use Carbon\Carbon;

use Illuminate\Validation\Factory;

use App\Http\Requests\BaseRequest;
use App\Services\PersonValidator;

class SaveRequest extends BaseRequest{
	
	public function rules(){
		return array(
			'last_name' => 'string|min:1|max:255|name_unique',
			'last_name_born' => 'string|min:1|max:255|name_unique',
			'middle_name' => 'string|min:1|max:255',
			'first_name' => 'string|min:1|max:255',
			'nick_name' => 'string|min:1|max:255',
			'birthday_year' => 'numeric',
			'birthday_month' => 'numeric',
			'birthday_day' => 'numeric',
			'birthday_hour' => 'numeric',
			'birthday_minute' => 'numeric',
			'deceased_at_year' => 'numeric',
			'deceased_at_month' => 'numeric',
			'deceased_at_day' => 'numeric',
			'first_met_at_year' => 'numeric',
			'first_met_at_month' => 'numeric',
			'first_met_at_day' => 'numeric',
			'facebook_id' => 'numeric',
			'blood_type' => 'string',
			'blood_type_rhd' => 'string',
			'default_event_type' => 'numeric',
			'comment' => 'string',
		);
	}
	
	public function input($key = null, $default = null){
		$input = parent::input($key, $default);
		
		switch($key){
			case 'gender':
				switch($input){
					case 'm':
					case 'f':
						break;
					
					default:
						$input = null;
						break;
				}
				break;
			
			case 'birthday':
				$birthdayYear = (int)$this->input('birthday_year');
				$birthdayMonth = (int)$this->input('birthday_month');
				$birthdayDay = (int)$this->input('birthday_day');
				$birthdayHour = (int)$this->input('birthday_hour');
				$birthdayMinute = (int)$this->input('birthday_minute');
				if($birthdayYear && $birthdayMonth && $birthdayDay){
					$birthday = new Carbon();
					$birthday->setDate($birthdayYear, $birthdayMonth, $birthdayDay);
					$birthday->setTime($birthdayHour, $birthdayMinute);
					$input = $birthday->format('Y-m-d H:i:s');
				}
				break;
			
			case 'deceased_at':
				$deceasedAtYear = (int)$this->input('deceased_at_year');
				$deceasedAtMonth = (int)$this->input('deceased_at_month');
				$deceasedAtDay = (int)$this->input('deceased_at_day');
				if($deceasedAtYear && $deceasedAtMonth && $deceasedAtDay){
					$deceasedAt = new Carbon();
					$deceasedAt->setDate($deceasedAtYear, $deceasedAtMonth, $deceasedAtDay);
					$input = $deceasedAt->format('Y-m-d');
				}
				break;
			
			case 'first_met_at':
				$firstMetAtYear = (int)$this->input('first_met_at_year');
				$firstMetAtMonth = (int)$this->input('first_met_at_month');
				$firstMetAtDay = (int)$this->input('first_met_at_day');
				if($firstMetAtYear && $firstMetAtMonth && $firstMetAtDay){
					$firstMetAt = new Carbon();
					$firstMetAt->setDate($firstMetAtYear, $firstMetAtMonth, $firstMetAtDay);
					$input = $firstMetAt->format('Y-m-d');
				}
				break;
			
			case 'blood_type':
				switch($input){
					case 'ga':
					case 'gb':
					case 'gab':
					case 'gn':
						$input = substr($input, 1);
						break;
					
					default:
						$input = null;
						break;
				}
				break;
			
			case 'blood_type_rhd':
				switch($input){
					case 't+':
					case 't-':
					case 'tn':
						$input = substr($input, 1);
						break;
					
					default:
						$input = null;
						break;
				}
				break;
			
			case 'default_event_type':
				if($input < 1000 || $input > 9999){
					$input = 1000;
				}
				break;
			
			case 'birthday_year':
			case 'birthday_month':
			case 'birthday_day':
			case 'birthday_hour':
			case 'birthday_minute':
			case 'deceased_at_year':
			case 'deceased_at_month':
			case 'deceased_at_day':
			case 'first_met_at_year':
			case 'first_met_at_month':
			case 'first_met_at_day':
				// Do nothing and take original value.
				break;
			
			default:
				$input['gender'] = $this->input('gender');
				$input['birthday'] = $this->input('birthday');
				$input['deceased_at'] = $this->input('deceased_at');
				$input['first_met_at'] = $this->input('first_met_at');
				$input['blood_type'] = $this->input('blood_type');
				$input['blood_type_rhd'] = $this->input('blood_type_rhd');
				$input['default_event_type'] = $this->input('default_event_type');
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

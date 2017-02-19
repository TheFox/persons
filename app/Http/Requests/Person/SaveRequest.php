<?php

namespace App\Http\Requests\Person;

use Carbon\Carbon;
use Illuminate\Validation\Factory;
use App\Http\Requests\BaseRequest;
use App\Services\PersonValidator;

class SaveRequest extends BaseRequest{
	
	public function rules(){
		$name = [
			'last_name' => 'required|string|min:1|max:255',
			'last_name_born' => 'nullable|string|min:1|max:255',
		];
		if($this instanceof StoreRequest){
			$name['last_name'] .= '|name_unique';
			$name['last_name_born'] .= '|name_unique';
		}
		
		$name['middle_name'] = 'nullable|string|min:1|max:255';
		$name['first_name'] = 'required|string|min:1|max:255';
		$name['nick_name'] = 'nullable|string|min:1|max:255';
		$name['birthday_year'] = 'nullable|numeric';
		$name['birthday_month'] = 'nullable|numeric';
		$name['birthday_day'] = 'nullable|numeric';
		$name['birthday_hour'] = 'nullable|numeric';
		$name['birthday_minute'] = 'nullable|numeric';
		$name['deceased_at_year'] = 'nullable|numeric';
		$name['deceased_at_month'] = 'nullable|numeric';
		$name['deceased_at_day'] = 'nullable|numeric';
		$name['first_met_at_year'] = 'nullable|numeric';
		$name['first_met_at_month'] = 'nullable|numeric';
		$name['first_met_at_day'] = 'nullable|numeric';
		$name['facebook_id'] = 'nullable|numeric';
		$name['facebook_url'] = 'nullable|string';
		$name['blood_type'] = 'nullable|string';
		$name['blood_type_rhd'] = 'nullable|string';
		$name['default_event_type'] = 'nullable|numeric';
		$name['comment'] = 'nullable|string';
		
		return $name;
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
			case 'deceased_at':
			case 'first_met_at':
				$date = $this->input($key.'_date');
				$time = $this->input($key.'_time');
				if($date){
					$dateTime = $date;
					if($time){
						$dateTime .= ' '.$time.':01';
					}
					$input = Carbon::parse($dateTime)->format('Y-m-d H:i:s');
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
			
			case 'facebook_url':
				$url = $input;
				if(strlen($url)){
					$urlCmp = strtolower($url);
					if(substr($urlCmp, 0, 8) != 'https://'){
						if(substr($urlCmp, 0, 7) == 'http://'){
							$url = substr($url, 7);
						}
						$url = 'https://'.$url;
						$input = $url;
					}
				}
				break;
			
			case 'birthday_date':
			case 'birthday_time':
			case 'deceased_at_date':
			case 'deceased_at_time':
			case 'first_met_at_date':
			case 'first_met_at_time':
			case 'attempt':
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
				$input['facebook_url'] = $this->input('facebook_url');
				break;
		}
		
		return $input;
	}
	
	public function validator(Factory $factory){
		if($this instanceof StoreRequest){
			$id = $this->route('id');
			$factory->resolver(function($translator, $data, $rules, $messages) use($id){
				$data['id'] = $id;
				
				$validator = new PersonValidator($translator, $data, $rules, $messages);
				return $validator;
			});
		}
		
		return $factory->make($this->input(), $this->container->call([$this, 'rules']), $this->messages());
	}
	
}

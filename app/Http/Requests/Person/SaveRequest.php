<?php namespace App\Http\Requests\Person;

use Carbon\Carbon;

use Illuminate\Validation\Factory;

use App\Http\Requests\BaseRequest;
use App\Services\PersonValidator;

class SaveRequest extends BaseRequest{
	
	public function rules(){
		$name = array(
			'last_name' => 'string|min:1|max:255',
			'last_name_born' => 'string|min:1|max:255',
		);
		if($this instanceof StoreRequest){
			$name['last_name'] .= '|name_unique';
			$name['last_name_born'] .= '|name_unique';
		}
		return $name + array(
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
			'facebook_url' => 'string',
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
		$id = $this->route('id');
		
		if($this instanceof StoreRequest){
			$factory->resolver(function($translator, $data, $rules, $messages) use($id){
				$data['id'] = $id;
				
				$validator = new PersonValidator($translator, $data, $rules, $messages);
				return $validator;
			});
		}
		
		return $factory->make($this->input(), $this->container->call(array($this, 'rules')), $this->messages());
	}
	
}

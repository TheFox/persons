<?php namespace App\Http\Requests\Person\Event;

use Carbon\Carbon;

use Illuminate\Validation\Factory;

use App\Http\Requests\BaseRequest;
use App\Services\PersonValidator;

class SaveRequest extends BaseRequest{
	
	public function rules(){
		return array(
			'happened_at_year' => 'numeric',
			'happened_at_month' => 'numeric',
			'happened_at_day' => 'numeric',
			'happened_at_hour' => 'numeric',
			'happened_at_minute' => 'numeric',
			'type' => 'numeric',
			'comment' => 'required|string',
		);
	}
	
	public function input($key = null, $default = null){
		$input = parent::input($key, $default);
		
		switch($key){
			case 'happened_at':
				$happenedAtYear = (int)$this->input('happened_at_year');
				$happenedAtMonth = (int)$this->input('happened_at_month');
				$happenedAtDay = (int)$this->input('happened_at_day');
				$happenedAtHour = (int)$this->input('happened_at_hour');
				$happenedAtMinute = (int)$this->input('happened_at_minute');
				if($happenedAtYear && $happenedAtMonth && $happenedAtDay){
					$happenedAt = new Carbon();
					$happenedAt->setDate($happenedAtYear, $happenedAtMonth, $happenedAtDay);
					$happenedAt->setTime($happenedAtHour, $happenedAtMinute);
					$input = $happenedAt->format('Y-m-d H:i:s');
				}
				break;
			
			case 'type':
				if($input < 1000 || $input > 9999){
					$input = 1000;
				}
				break;
			
			case 'title':
				$title = $this->input('comment');
				$title = str_replace("\r", '', $title);
				$pos = strpos($title, "\n");
				if($pos !== false){
					$title = substr($title, 0, $pos);
				}
				if(strlen($title) > 25){
					$title = substr($title, 0, 20).'...';
				}
				$input = $title;
				break;
			
			case 'happened_at_year':
			case 'happened_at_month':
			case 'happened_at_day':
			case 'happened_at_hour':
			case 'happened_at_minute':
			case 'comment':
			case 'fwd_back':
				// Do nothing and take original value.
				break;
			
			default:
				$input['happened_at'] = $this->input('happened_at');
				$input['type'] = $this->input('type');
				$input['title'] = $this->input('title');
				break;
		}
		
		return $input;
	}
	
}

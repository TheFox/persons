<?php namespace App\Http\Controllers;

use Carbon\Carbon;

use View;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Person\CreateRequest;
use App\Http\Requests\Person\StoreRequest;
use App\Http\Requests\Person\EditRequest;
use App\Http\Requests\Person\UpdateRequest;
use App\Http\Requests\Person\DeleteRequest;
use App\Http\Requests\Person\DestroyRequest;
use App\Http\Requests\Person\ShowRequest;
use App\Http\Requests\Person\SearchOutputRequest;
use App\Person;
use App\PersonEvent;

class PersonController extends Controller{
	
	public static $BLOOD_TYPES = array(
		'ga' => 'Group A',
		'gb' => 'Group B',
		'gab' => 'Group AB',
		'gn' => 'Group 0',
	);
	public static $BLOOD_TYPES_RHD = array(
		't+' => 'positive',
		't-' => 'negative',
		'tn' => 'null',
	);
	
	public function index(Request $request, $page = 1){
		$user = Auth::user();
		$userId = $user->id;
		
		$now = Carbon::today();
		
		$personsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC');
		$persons = $personsBuilder->get();
		
		foreach($persons as $personId => $person){
			$person->diff = '';
			$person->diff_color = '';
			if($person->birthday){
				$birthdayThisYear = new Carbon($now->format('Y').'-'.$person->birthday->format('m-d'));
				
				$diff = $birthdayThisYear->diff($now);
				$person->diff = $diff->format('%R%a days');
				
				$diffInt = (int)$diff->format('%R%a');
				if($diffInt == 0){
					$person->diff = 'Today';
				}
				if($diffInt >= -14 && $diffInt <= 0){
					$person->diff_color = '#006400';
				}
				elseif($diffInt < -14){
					$person->diff_color = '#ff8c00';
				}
				
			}
		}
		
		$view = View::make('person.list', array(
			'persons' => $persons,
		));
		return $view;
	}
	
	public function create(CreateRequest $request){
		$person = array();
		$attempt = 1;
		if($request->old()){
			$person = $request->old();
			$attempt = (int)$person['attempt'] + 1;
			unset($person['attempt']);
		}
		$person['id'] = 0;
		
		$view = View::make('person.create', array(
			'person' => $person,
			'groupTypes' => static::$BLOOD_TYPES,
			'rhdTypes' => static::$BLOOD_TYPES_RHD,
			'eventTypes' => PersonEvent::$EVENT_TYPES,
			'attempt' => $attempt,
		));
		return $view;
	}
	
	public function quickCreate(CreateRequest $request){
		$person = array();
		$attempt = 1;
		if($request->old()){
			$person = $request->old();
			$attempt = (int)$person['attempt'] + 1;
			unset($person['attempt']);
		}
		$person['id'] = 0;
		
		$view = View::make('person.quick_create', array(
			'person' => $person,
			'attempt' => $attempt,
		));
		return $view;
	}
	
	public function store(StoreRequest $request){
		$user = Auth::user();
		$userId = 0;
		if($user){
			$userId = $user->id;
		}
		
		$fields = $request->input();
		$person = new Person($fields);
		$person->updateName();
		$person->user_id = $userId;
		$person->save();
		
		$response = redirect()->route('person.show', array('id' => $person->id));
		return $response;
	}
	
	public function edit(EditRequest $request, $id){
		$person = $request->person;
		$attempt = 1;
		if($request->old()){
			$person = $request->old();
			$person['id'] = $id;
			$attempt = (int)$person['attempt'] + 1;
			unset($person['attempt']);
		}
		
		$view = View::make('person.edit', array(
			'person' => $person,
			'groupTypes' => static::$BLOOD_TYPES,
			'rhdTypes' => static::$BLOOD_TYPES_RHD,
			'eventTypes' => PersonEvent::$EVENT_TYPES,
			'attempt' => $attempt,
		));
		return $view;
	}
	
	public function update(UpdateRequest $request, $id){
		$user = Auth::user();
		$userId = 0;
		if($user){
			$userId = $user->id;
		}
		
		$person = $request->person;
		
		$fields = $request->input();
		
		$person->update($fields);
		$person->updateName();
		$person->save();
		
		$response = redirect()->route('person.show', array('id' => $person->id));
		return $response;
	}
	
	public function delete(DeleteRequest $request, $id){
		$person = $request->person;
		
		$view = View::make('person.delete', array(
			'person' => $person,
		));
		return $view;
	}
	
	public function destroy(DestroyRequest $request, $id){
		$now = Carbon::now();
		
		$person = $request->person;
		$person->deleted_at = $now;
		$person->save();
		
		$response = redirect()
			->route('person.list')
			->with('message', 'Person ID='.$person->id.' deleted.');
		return $response;
	}
	
	public function show(ShowRequest $request, $id){
		$now = Carbon::today();
		
		$person = $request->person;
		$allEvents = (int)$request->input('all_events', 0);
		
		if($person->blood_type){
			$person->blood_type = static::$BLOOD_TYPES['g'.$person->blood_type];
		}
		$person->blood_type_rhd_is_set = false;
		if($person->blood_type_rhd !== null){
			$person->blood_type_rhd_is_set = true;
			$person->blood_type_rhd = static::$BLOOD_TYPES_RHD['t'.$person->blood_type_rhd];
		}
		
		$person->ageAtDeath = '';
		$person->ageToday = '';
		if($person->birthday){
			$diffToday = $person->birthday->diff($now);
			$person->ageToday = $diffToday->format('%y years, %m months, %d days');
			if($person->deceased_at){
				$diffAtDead = $person->birthday->diff($person->deceased_at);
				$person->ageAtDeath = $diffAtDead->format('%y years, %m months, %d days');
			}
		}
		
		$person->first_met_at_diff = '';
		if($person->first_met_at){
			$diffToday = $person->first_met_at->diff($now);
			$person->first_met_at_diff = $diffToday->format('%y years, %m months, %d days');
		}
		
		$comment = $person->comment;
		$comment = str_replace("\n", '<br />', $comment);
		$person->comment = $comment;
		
		$eventsBuilder = PersonEvent::
			select('*', DB::raw('COALESCE(happened_at, created_at) as hc_date'))
			->whereNull('deleted_at')
			->where('person_id', '=', $person->id)
			->orderBy('hc_date', 'DESC')
			->orderBy('id', 'DESC');
		if(!$allEvents){
			$eventsBuilder->take(5);
		}
		$events = $eventsBuilder->get();
		
		$view = View::make('person.show', array(
			'person' => $person,
			'events' => $events,
			'eventTypes' => PersonEvent::$EVENT_TYPES,
			'genderTypes' => array('m' => '&#9794; Male', 'f' => '&#9792; Female'),
		));
		return $view;
	}
	
	public function searchInput(Request $request){
		$view = View::make('person.search-input', array(
			
		));
		return $view;
	}
	
	public function searchOutput(SearchOutputRequest $request){
		$user = Auth::user();
		$userId = $user->id;
		
		$id = $request->input('id', 0);
		$lastName = $request->input('last_name', 0);
		$firstName = $request->input('first_name', 0);
		
		$personsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC');
		
		$personsBuilder->where(function($query) use($id, $lastName, $firstName){
			if($id){
				$query->where('id', '=', $id, 'or');
			}
			if($lastName){
				$query->where('last_name', 'like', '%'.$lastName.'%', 'or');
				$query->where('last_name_born', 'like', '%'.$lastName.'%', 'or');
			}
			if($firstName){
				$query->where('first_name', 'like', '%'.$firstName.'%', 'or');
				$query->where('nick_name', 'like', '%'.$firstName.'%', 'or');
			}
		});
		
		$sql = $personsBuilder->toSql();
		$persons = $personsBuilder->get();
		
		$view = View::make('person.search-output', array(
			'persons' => $persons,
			'sql' => $sql,
		));
		return $view;
	}
	
}

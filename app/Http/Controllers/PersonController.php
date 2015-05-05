<?php namespace App\Http\Controllers;

use DateTime;

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
		
		$now = new DateTime('now');
		$now->setTime(0, 0, 0);
		
		$personsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC');
		$persons = $personsBuilder->get();
		
		foreach($persons as $personId => $person){
			$person->diff = '';
			$person->diff_color = '';
			if($person->birthday){
				$birthday = new DateTime($person->birthday);
				$birthdayThisYear = new DateTime($now->format('Y').'-'.$birthday->format('m-d'));
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
		if($request->old()){
			$person = $request->old();
		}
		$person['id'] = 0;
		
		$view = View::make('person.create', array(
			'person' => $person,
			'groupTypes' => static::$BLOOD_TYPES,
			'rhdTypes' => static::$BLOOD_TYPES_RHD,
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
		$person = Person::find($id);
		if($request->old()){
			$person = $request->old();
			$person['id'] = $id;
		}
		
		$view = View::make('person.edit', array(
			'person' => $person,
			'groupTypes' => static::$BLOOD_TYPES,
			'rhdTypes' => static::$BLOOD_TYPES_RHD,
		));
		return $view;
	}
	
	public function update(UpdateRequest $request, $id){
		$user = Auth::user();
		$userId = 0;
		if($user){
			$userId = $user->id;
		}
		
		$person = Person::find($id);
		
		$fields = $request->input();
		
		$person->update($fields);
		$person->updateName();
		$person->save();
		
		$response = redirect()->route('person.show', array('id' => $person->id));
		return $response;
	}
	
	public function delete(DeleteRequest $request, $id){
		$person = Person::find($id);
		
		$view = View::make('person.delete', array(
			'person' => $person,
		));
		return $view;
	}
	
	public function destroy(DestroyRequest $request, $id){
		Person::where('id', '=', $id)->update(array('deleted_at' => DB::raw('CURRENT_TIMESTAMP')));
		
		$response = redirect()
			->route('person.list')
			->with('message', 'Person ID='.$id.' deleted.');
		return $response;
	}
	
	public function show(ShowRequest $request, $id){
		$person = Person::find($id);
		
		$person->blood_type_rhd_is_set = false;
		if($person->blood_type_rhd !== null){
			$person->blood_type_rhd_is_set = true;
		}
		
		$view = View::make('person.show', array(
			'person' => $person,
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

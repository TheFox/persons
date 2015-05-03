<?php namespace App\Http\Controllers;

use DateTime;

use View;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

use App\Http\Controllers\Controller;
use App\Http\Requests\Person\CreatePersonRequest;
use App\Http\Requests\Person\StorePersonRequest;
use App\Http\Requests\Person\EditPersonRequest;
use App\Http\Requests\Person\UpdatePersonRequest;
use App\Http\Requests\Person\DeletePersonRequest;
use App\Http\Requests\Person\DestroyPersonRequest;
use App\Http\Requests\Person\ShowPersonRequest;
use App\Http\Requests\Person\SearchOutputPersonRequest;
use App\Person;

class PersonController extends Controller{
	
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
	
	public function create(CreatePersonRequest $request){
		$person = array();
		if($request->old()){
			$person = $request->old();
		}
		$person['id'] = 0;
		
		$view = View::make('person.create', array(
			'person' => $person,
		));
		return $view;
	}
	
	public function store(StorePersonRequest $request){
		$user = Auth::user();
		$userId = 0;
		if($user){
			$userId = $user->id;
		}
		
		$fields = $request->input();
		
		
		$person = new Person($fields);
		$person->user_id = $userId;
		$person->save();
		
		$response = redirect()->route('person.show', array('id' => $person->id));
		return $response;
	}
	
	public function edit(EditPersonRequest $request, $id){
		$person = Person::find($id);
		if($request->old()){
			$person = $request->old();
			$person['id'] = $id;
		}
		
		$view = View::make('person.edit', array(
			'person' => $person,
		));
		return $view;
	}
	
	public function update(UpdatePersonRequest $request, $id){
		$user = Auth::user();
		$userId = 0;
		if($user){
			$userId = $user->id;
		}
		
		$person = Person::find($id);
		
		$fields = $request->input();
		
		$person->update($fields);
		$person->updateName();
		
		$response = redirect()->route('person.show', array('id' => $person->id));
		return $response;
	}
	
	public function delete(DeletePersonRequest $request, $id){
		$person = Person::find($id);
		
		$view = View::make('person.delete', array(
			'person' => $person,
		));
		return $view;
	}
	
	public function destroy(DestroyPersonRequest $request, $id){
		Person::where('id', '=', $id)->update(array('deleted_at' => DB::raw('CURRENT_TIMESTAMP')));
		
		$response = redirect()
			->route('person.list')
			->with('message', 'Person ID='.$id.' deleted.');
		return $response;
	}
	
	public function show(ShowPersonRequest $request, $id){
		$person = Person::find($id);
		
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
	
	public function searchOutput(SearchOutputPersonRequest $request){
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
			}
			if($firstName){
				$query->where('first_name', 'like', '%'.$firstName.'%', 'or');
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

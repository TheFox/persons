<?php namespace App\Http\Controllers;

use View;
use DB;
use Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests\Person\Event\CreateRequest;
use App\Http\Requests\Person\Event\StoreRequest;
use App\Http\Requests\Person\Event\EditRequest;
use App\Http\Requests\Person\Event\UpdateRequest;
use App\Http\Requests\Person\Event\ShowRequest;
use App\Http\Requests\Person\Event\DeleteRequest;
use App\Http\Requests\Person\Event\DestroyRequest;

use App\Person;
use App\PersonEvent;

class PersonEventController extends Controller{
	
	public function create(CreateRequest $request, $id){
		$person = $request->person;
		
		$event = array();
		if($request->old()){
			$event = $request->old();
		}
		$event['id'] = 0;
		
		$view = View::make('person.event.create', array(
			'person' => $person,
			'event' => $event,
			'eventTypes' => PersonEvent::$EVENT_TYPES,
		));
		return $view;
	}
	
	public function store(StoreRequest $request, $id){
		$person = $request->person;
		$fwdBack = (int)$request->input('fwd_back', 0);
		
		$user = Auth::user();
		$userId = 0;
		if($user){
			$userId = $user->id;
		}
		
		$fields = $request->input();
		$event = new PersonEvent($fields);
		$event->user_id = $userId;
		$event->person_id = $person->id;
		$event->save();
		
		$response = null;
		if($fwdBack){
			$response = redirect()->back();
		}
		else{
			$response = redirect()->route('person.event.show', array('id' => $event->id));
		}
		return $response;
	}
	
	public function edit(EditRequest $request, $id){
		$event = $request->event;
		$person = $event->person;
		if($request->old()){
			$event = $request->old();
			$event['id'] = $id;
		}
		
		$view = View::make('person.event.edit', array(
			'event' => $event,
			'person' => $person,
			'eventTypes' => PersonEvent::$EVENT_TYPES,
		));
		return $view;
	}
	
	public function update(UpdateRequest $request, $id){
		$user = Auth::user();
		$userId = 0;
		if($user){
			$userId = $user->id;
		}
		
		$event = $request->event;
		$fields = $request->input();
		$event->update($fields);
		$event->save();
		
		$response = redirect()->route('person.event.show', array('id' => $event->id));
		return $response;
	}
	
	public function show(ShowRequest $request, $id){
		$event = $request->event;
		$person = $event->person;
		
		$comment = $event->comment;
		$comment = str_replace("\n", '<br />', $comment);
		$event->comment = $comment;
		
		$view = View::make('person.event.show', array(
			'event' => $event,
			'person' => $person,
			'eventTypes' => PersonEvent::$EVENT_TYPES,
		));
		return $view;
	}
	
	public function delete(DeleteRequest $request, $id){
		$event = $request->event;
		
		$view = View::make('person.event.delete', array(
			'event' => $event,
		));
		return $view;
	}
	
	public function destroy(DestroyRequest $request, $id){
		$event = $request->event;
		$person = $event->person;
		PersonEvent::where('id', '=', $id)->update(array('deleted_at' => DB::raw('CURRENT_TIMESTAMP')));
		
		$response = redirect()
			->route('person.show', array('id' => $person->id))
			->with('message', 'Person ID='.$id.' deleted.');
		return $response;
	}
	
}

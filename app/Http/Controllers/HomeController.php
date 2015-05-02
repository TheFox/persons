<?php namespace App\Http\Controllers;

use DateTime;

use View;
use Auth;
use DB;

use App\Person;

class HomeController extends Controller{

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->middleware('auth');
	}
	
	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(){
		$user = Auth::user();
		$userId = $user->id;
		
		$now = new DateTime('now');
		$now->setTime(0, 0, 0);
		
		$upcomingBirthdaysPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->where(DB::raw("date(concat(year(now()), '-', substring(birthday, 6)))"), '>=', DB::raw("str_to_date(now(), '%Y-%m-%d')"))
			->select('*', DB::raw('substring(birthday, 6) as birthday_month_day'))
			->orderBy('birthday_month_day', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(10);
		$upcomingBirthdaysPersons = $upcomingBirthdaysPersonsBuilder->get();
		
		foreach($upcomingBirthdaysPersons as $personId => $person){
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
		
		$view = View::make('home', array(
			'upcomingBirthdaysPersons' => $upcomingBirthdaysPersons,
		));
		return $view;
	}

}

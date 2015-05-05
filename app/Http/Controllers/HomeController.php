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
		
		$newestPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->orderBy('id', 'DESC')
			->take(5);
		$newestPersons = $newestPersonsBuilder->get();
		
		$lastestEditPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->orderBy('updated_at', 'DESC')
			->orderBy('id', 'DESC')
			->take(5);
		$lastestEditPersons = $lastestEditPersonsBuilder->get();
		
		$upcomingBirthdaysAllPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->where(DB::raw("date(concat(year(now()), '-', substring(birthday, 6)))"), '>=', DB::raw("str_to_date(now(), '%Y-%m-%d')"))
			->select('*', DB::raw('substring(birthday, 6) as birthday_month_day'), DB::raw("YEAR(now()) - YEAR(birthday) as age"))
			->orderBy('birthday_month_day', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(10);
		$upcomingBirthdaysAllPersons = $upcomingBirthdaysAllPersonsBuilder->get();
		
		foreach($upcomingBirthdaysAllPersons as $personId => $person){
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
		
		$upcomingBirthdaysAlivePersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->whereNull('deceased_at')
			->where(DB::raw("date(concat(year(now()), '-', substring(birthday, 6)))"), '>=', DB::raw("str_to_date(now(), '%Y-%m-%d')"))
			->select('*', DB::raw('substring(birthday, 6) as birthday_month_day'), DB::raw("YEAR(now()) - YEAR(birthday) as age"))
			->orderBy('birthday_month_day', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(10);
		$upcomingBirthdaysAlivePersons = $upcomingBirthdaysAlivePersonsBuilder->get();
		
		foreach($upcomingBirthdaysAlivePersons as $personId => $person){
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
		
		$upcomingMinorFirstMetPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('first_met_at')
			->where(DB::raw("date(concat(year(now()), '-', substring(first_met_at, 6)))"), '>=', DB::raw("str_to_date(now(), '%Y-%m-%d')"))
			->select('*', DB::raw('substring(first_met_at, 6) as first_met_at_month_day'), DB::raw("YEAR(now()) - YEAR(first_met_at) as years"))
			->orderBy('first_met_at_month_day', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(10);
		$upcomingMinorFirstMetPersons = $upcomingMinorFirstMetPersonsBuilder->get();

		foreach($upcomingMinorFirstMetPersons as $personId => $person){
			$firstMetAt = new DateTime($person->first_met_at);
			$firstMetAtThisYear = new DateTime($now->format('Y').'-'.$firstMetAt->format('m-d'));
			$diff = $firstMetAtThisYear->diff($now);
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
		
		$upcomingMajorFirstMetPersons = array();
		$upcomingMajorFirstMetPersonsTable1 = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('first_met_at')
			->where(DB::raw("date(concat(year(now()), '-', substring(first_met_at, 6)))"), '>=', DB::raw("str_to_date(now(), '%Y-%m-%d')"))
			->select('*', DB::raw('substring(first_met_at, 6) as first_met_at_month_day'), DB::raw("YEAR(now()) - YEAR(first_met_at) as years"))
			->orderBy('first_met_at_month_day', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC');
		$sql = $upcomingMajorFirstMetPersonsTable1->toSql();
		
		$upcomingMajorFirstMetPersonsTable2 = DB::table(DB::raw('('.$sql.') as table1'))
			->mergeBindings($upcomingMajorFirstMetPersonsTable1->getQuery())
			->where(DB::raw('years % 5'), '=', 0)
			->take(10);
		$upcomingMajorFirstMetPersons = $upcomingMajorFirstMetPersonsTable2->get();
		$sql = $upcomingMajorFirstMetPersonsTable2->toSql();
		
		foreach($upcomingMajorFirstMetPersons as $personId => $person){
			$firstMetAt = new DateTime($person->first_met_at);
			$firstMetAtThisYear = new DateTime($now->format('Y').'-'.$firstMetAt->format('m-d'));
			$diff = $firstMetAtThisYear->diff($now);
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
		
		$youngestPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->select('*', DB::raw("YEAR(now()) - YEAR(birthday) as age"))
			->orderBy('birthday', 'DESC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(5);
		$youngestPersons = $youngestPersonsBuilder->get();
		
		$oldestPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->select('*', DB::raw("YEAR(now()) - YEAR(birthday) as age"))
			->orderBy('birthday', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(5);
		$oldestPersons = $oldestPersonsBuilder->get();
		
		$view = View::make('home', array(
			'newestPersons' => $newestPersons,
			'lastestEditPersons' => $lastestEditPersons,
			'upcomingBirthdaysAllPersons' => $upcomingBirthdaysAllPersons,
			'upcomingBirthdaysAlivePersons' => $upcomingBirthdaysAlivePersons,
			'upcomingMinorFirstMetPersons' => $upcomingMinorFirstMetPersons,
			'upcomingMajorFirstMetPersons' => $upcomingMajorFirstMetPersons,
			'youngestPersons' => $youngestPersons,
			'oldestPersons' => $oldestPersons,
			'sql' => $sql,
		));
		return $view;
	}

}

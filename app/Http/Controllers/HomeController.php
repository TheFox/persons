<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use View;
use Auth;
use DB;
use App\Person;

class HomeController extends Controller{
	
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct(){
		$this->middleware('auth');
	}
	
	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(){
		// dd(microtime(true) - LARAVEL_START);
		
		$user = Auth::user();
		$userId = $user->id;
		
		$now = Carbon::today();
		
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
			->select('*', DB::raw('substring(birthday, 6) as birthday_month_day'), DB::raw('YEAR(now()) - YEAR(birthday) as age'))
			->orderBy('birthday_month_day', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(10);
		$upcomingBirthdaysAllPersons = $upcomingBirthdaysAllPersonsBuilder->get();
		
		foreach($upcomingBirthdaysAllPersons as $personId => $person){
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
		
		$upcomingBirthdaysAlivePersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->whereNull('deceased_at')
			->where(DB::raw("date(concat(year(now()), '-', substring(birthday, 6)))"), '>=', DB::raw("str_to_date(now(), '%Y-%m-%d')"))
			->select('*', DB::raw('substring(birthday, 6) as birthday_month_day'), DB::raw('YEAR(now()) - YEAR(birthday) as age'))
			->orderBy('birthday_month_day', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(10);
		$upcomingBirthdaysAlivePersons = $upcomingBirthdaysAlivePersonsBuilder->get();
		
		foreach($upcomingBirthdaysAlivePersons as $personId => $person){
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
		
		$upcomingBirthdaysDeadPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->whereNotNull('deceased_at')
			->where(DB::raw("date(concat(year(now()), '-', substring(birthday, 6)))"), '>=', DB::raw("str_to_date(now(), '%Y-%m-%d')"))
			->select('*', DB::raw('substring(birthday, 6) as birthday_month_day'), DB::raw('YEAR(deceased_at) - YEAR(birthday) as age'))
			->orderBy('birthday_month_day', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(10);
		$upcomingBirthdaysDeadPersons = $upcomingBirthdaysDeadPersonsBuilder->get();
		
		foreach($upcomingBirthdaysDeadPersons as $personId => $person){
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
		
		$upcomingMinorFirstMetPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('first_met_at')
			->where(DB::raw("date(concat(year(now()), '-', substring(first_met_at, 6)))"), '>=', DB::raw("str_to_date(now(), '%Y-%m-%d')"))
			->select('*', DB::raw('substring(first_met_at, 6) as first_met_at_month_day'), DB::raw('YEAR(now()) - YEAR(first_met_at) as years'))
			->orderBy('first_met_at_month_day', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(10);
		$upcomingMinorFirstMetPersons = $upcomingMinorFirstMetPersonsBuilder->get();

		foreach($upcomingMinorFirstMetPersons as $personId => $person){
			$firstMetAtThisYear = new Carbon($now->format('Y').'-'.$person->first_met_at->format('m-d'));
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
		
		$upcomingMajorFirstMetPersons = [];
		$upcomingMajorFirstMetPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('first_met_at')
			->where(DB::raw("date(concat(year(now()), '-', substring(first_met_at, 6)))"), '>=', DB::raw("str_to_date(now(), '%Y-%m-%d')"))
			->where(DB::raw('(YEAR(now()) - YEAR(first_met_at)) % 5'), '=', DB::raw('0'))
			->select('*', DB::raw('substring(first_met_at, 6) as first_met_at_month_day'), DB::raw('YEAR(now()) - YEAR(first_met_at) as years'))
			->orderBy('first_met_at_month_day', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(10);
		$upcomingMajorFirstMetPersons = $upcomingMajorFirstMetPersonsBuilder->get();
		
		foreach($upcomingMajorFirstMetPersons as $personId => $person){
			$firstMetAtThisYear = new Carbon($now->format('Y').'-'.$person->first_met_at->format('m-d'));
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
		
		$youngestAllPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->select('*', DB::raw('YEAR(now()) - YEAR(birthday) as age'))
			->orderBy('birthday', 'DESC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(5);
		$youngestAllPersons = $youngestAllPersonsBuilder->get();
		
		$youngestPersonsAliveBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->whereNull('deceased_at')
			->select('*', DB::raw('YEAR(now()) - YEAR(birthday) as age'))
			->orderBy('birthday', 'DESC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(5);
		$youngestAlivePersons = $youngestPersonsAliveBuilder->get();
		
		$youngestPersonsDeadBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->whereNotNull('deceased_at')
			->select('*', DB::raw('YEAR(deceased_at) - YEAR(birthday) as age'))
			->orderBy('birthday', 'DESC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(5);
		$youngestDeadPersons = $youngestPersonsDeadBuilder->get();
		
		$oldestAllPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->select('*', DB::raw('YEAR(now()) - YEAR(birthday) as age'))
			->orderBy('birthday', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(5);
		$oldestAllPersons = $oldestAllPersonsBuilder->get();
		
		$oldestAlivePersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->whereNull('deceased_at')
			->select('*', DB::raw('YEAR(now()) - YEAR(birthday) as age'))
			->orderBy('birthday', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(5);
		$oldestAlivePersons = $oldestAlivePersonsBuilder->get();
		
		$oldestDeadPersonsBuilder = Person::whereNull('deleted_at')
			->where('user_id', '=', $userId)
			->whereNotNull('birthday')
			->whereNotNull('deceased_at')
			->select('*', DB::raw('YEAR(deceased_at) - YEAR(birthday) as age'))
			->orderBy('birthday', 'ASC')
			->orderBy('last_name', 'ASC')
			->orderBy('first_name', 'ASC')
			->take(5);
		$oldestDeadPersons = $oldestDeadPersonsBuilder->get();
		
		$sql = $oldestAlivePersonsBuilder->toSql();
		
		$view = View::make('home', [
			'newestPersons' => $newestPersons,
			'lastestEditPersons' => $lastestEditPersons,
			'upcomingBirthdaysAllPersons' => $upcomingBirthdaysAllPersons,
			'upcomingBirthdaysAlivePersons' => $upcomingBirthdaysAlivePersons,
			'upcomingBirthdaysDeadPersons' => $upcomingBirthdaysDeadPersons,
			'upcomingMinorFirstMetPersons' => $upcomingMinorFirstMetPersons,
			'upcomingMajorFirstMetPersons' => $upcomingMajorFirstMetPersons,
			'youngestAllPersons' => $youngestAllPersons,
			'youngestAlivePersons' => $youngestAlivePersons,
			'youngestDeadPersons' => $youngestDeadPersons,
			'oldestAllPersons' => $oldestAllPersons,
			'oldestAlivePersons' => $oldestAlivePersons,
			'oldestDeadPersons' => $oldestDeadPersons,
			'sql' => $sql,
		]);
		
		// dd(microtime(true) - LARAVEL_START);
		return $view;
	}
	
}

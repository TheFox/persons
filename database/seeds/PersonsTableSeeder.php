<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Person;

class PersonsTableSeeder extends Seeder{
	
	public function run(){
		DB::table('persons')->delete();
		
		$now = Carbon::now();
		$tomorrow = Carbon::now();
		$tomorrow->modify('+1 day');
		$nextWeek = Carbon::now();
		$nextWeek->modify('+7 days');
		$lastWeek = Carbon::now();
		$lastWeek->modify('-7 days');
		$lastYearlastWeek = Carbon::now();
		$lastYearlastWeek->modify('-2 years');
		$lastYearlastWeek->modify('-7 days');
		$fiveYears = Carbon::now();
		$fiveYears->modify('-5 years');
		$fiveYears->modify('+7 days');
		$tenYears = Carbon::now();
		$tenYears->modify('-10 years');
		$tenYears->modify('+7 days');
		
		
		$id = 0;
		
		$tpl = [
			'user_id' => 1,
			'created_at' => '2015-01-01 12:00:00',
			'comment' => '',
		];
		
		for($i = 0; $i < 4; $i++){
			$id++;
			$tpl['name'] = 'name_'.$id;
			$tpl['last_name'] = 'last_name_'.$id;
			$tpl['middle_name'] = 'middle_name_'.$id;
			$tpl['first_name'] = 'first_name_'.$id;
			$tpl['nick_name'] = 'nick_name_'.$id;
			$tpl['birthday'] = '1987-02-21';
			$tpl['first_met_at'] = '2005-01-01';
			Person::create($tpl);
		}
		
		for($i = 2000; $i < 2012; $i++){
			$id++;
			$tpl['name'] = 'name_'.$id;
			$tpl['last_name'] = 'last_name_'.$id;
			$tpl['middle_name'] = 'middle_name_'.$id;
			$tpl['first_name'] = 'first_name_'.$id;
			$tpl['nick_name'] = 'nick_name_'.$id;
			$tpl['birthday'] = '2000-02-21';
			$tpl['first_met_at'] = $i.'-06-01';
			Person::create($tpl);
		}
		
		Person::create([
			'user_id' => 1,
			'name' => 'fn ln',
			'last_name' => 'ln1',
			'first_name' => 'fn',
			'birthday' => '2001-01-05',
			'comment' => '',
			
			'deceased_at' => '2005-01-01',
		]);
		Person::create([
			'user_id' => 1,
			'name' => 'fn ln',
			'last_name' => 'ln2',
			'first_name' => 'fn',
			'birthday' => '1980-12-31',
			'comment' => '',
			
			'deceased_at' => '2005-01-01',
		]);
		Person::create([
			'user_id' => 1,
			'name' => 'fn ln',
			'last_name' => 'ln3',
			'first_name' => 'fn',
			'birthday' => '1980-'.$now->format('m-d'),
			'comment' => '',
		]);
		Person::create([
			'user_id' => 1,
			'name' => 'fn ln',
			'last_name' => 'ln4',
			'first_name' => 'fn',
			'birthday' => '1981-'.$tomorrow->format('m-d'),
			'comment' => '',
		]);
		Person::create([
			'user_id' => 1,
			'name' => 'fn ln',
			'last_name' => 'ln5',
			'first_name' => 'fn',
			'birthday' => '1982-'.$nextWeek->format('m-d'),
			'comment' => '',
		]);
		Person::create([
			'user_id' => 1,
			'name' => 'fn ln',
			'last_name' => 'ln6',
			'first_name' => 'fn',
			'birthday' => '2001-01-05',
			'comment' => '',
			
			'first_met_at' => '1982-'.$nextWeek->format('m-d'),
		]);
		Person::create([
			'user_id' => 1,
			'name' => 'fn ln',
			'last_name' => 'ln7',
			'first_name' => 'fn',
			'birthday' => '1901-'.$nextWeek->format('m-d'),
			'comment' => '',
			
			'deceased_at' => $lastYearlastWeek->format('Y-m-d'),
		]);
		Person::create([
			'user_id' => 1,
			'name' => 'fn ln',
			'last_name' => 'ln8',
			'first_name' => 'fn',
			'birthday' => '2001-01-05',
			'comment' => '',
			
			'first_met_at' => $fiveYears,
		]);
		Person::create([
			'user_id' => 1,
			'name' => 'fn ln',
			'last_name' => 'ln9',
			'first_name' => 'fn',
			'birthday' => '2001-01-05',
			'comment' => '',
			
			'first_met_at' => $tenYears,
		]);
	}
	
}

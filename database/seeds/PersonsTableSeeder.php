<?php

use Illuminate\Database\Seeder;

use App\Person;

class PersonsTableSeeder extends Seeder{
	
	public function run(){
		DB::table('persons')->delete();
		
		$id = 0;
		
		$tpl = array(
			'user_id' => 1,
			'created_at' => '2015-01-01 12:00:00',
		);
		
		for($i = 0; $i < 4; $i++){
			$id++;
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
			$tpl['last_name'] = 'last_name_'.$id;
			$tpl['middle_name'] = 'middle_name_'.$id;
			$tpl['first_name'] = 'first_name_'.$id;
			$tpl['nick_name'] = 'nick_name_'.$id;
			$tpl['birthday'] = '2000-02-21';
			$tpl['first_met_at'] = $i.'-06-01';
			Person::create($tpl);
		}
		
	}
	
}

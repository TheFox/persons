<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

include_once 'UsersTableSeeder.php';
include_once 'PersonsTableSeeder.php';
include_once 'PersonEventsTableSeeder.php';

class DatabaseSeeder extends Seeder{

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run(){
		Model::unguard();
		
		$this->command->info('Users table seed');
		$this->call('UsersTableSeeder');
		
		$this->command->info('Persons table seed');
		$this->call('PersonsTableSeeder');
		
		$this->command->info('Person Events table seed');
		$this->call('PersonEventsTableSeeder');
	}
	
}

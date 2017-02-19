<?php

/**
 * Revert Timestamps from
 * 2017_01_29_010000_update_persons_table Migration
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Person;

class RevertPersons20170129 extends Migration{
	
	public function up(){
		// return;
		// print "RevertPersons20170129 up\n";
		
		// $person = new Person();
		// $tableName = DB::getQueryGrammar()->wrapTable($person->getTable());
		// DB::statement('ALTER TABLE '.$tableName.'
		// 	CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT \'0000-00-00 00:00:00\',
		// 	CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT \'0000-00-00 00:00:00\';');
	}
	
	public function down(){
		// return;
		// print "RevertPersons20170129 down\n";
		
		// $person = new Person();
		// $tableName = DB::getQueryGrammar()->wrapTable($person->getTable());
		// DB::statement('ALTER TABLE '.$tableName.'
		// 	CHANGE `created_at` `created_at` TIMESTAMP NULL,
		// 	CHANGE `updated_at` `updated_at` TIMESTAMP NULL;');
	}
	
}

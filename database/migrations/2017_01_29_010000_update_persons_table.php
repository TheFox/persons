<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Person;

class UpdatePersonsTable extends Migration{
	
	public function up(){
		Schema::table('persons', function(Blueprint $table){
			$person = new Person();
			$tableName = DB::getQueryGrammar()->wrapTable($person->getTable());
			DB::statement('ALTER TABLE '.$tableName.' CHANGE `created_at` `created_at` TIMESTAMP NULL, CHANGE `updated_at` `updated_at` TIMESTAMP NULL;');
			
			$table->string('last_name_born', 255)->nullable()->change();
			$table->string('middle_name', 255)->nullable()->change();
			$table->string('nick_name', 255)->nullable()->change();
		});
	}
	
	public function down(){
		$person = new Person();
		$tableName = DB::getQueryGrammar()->wrapTable($person->getTable());
		DB::statement('ALTER TABLE '.$tableName.' CHANGE `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT \'0000-00-00 00:00:00\', CHANGE `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT \'0000-00-00 00:00:00\';');
		
		$table->string('last_name_born', 255)->nullable(false)->change();
		$table->string('middle_name', 255)->nullable(false)->change();
		$table->string('nick_name', 255)->nullable(false)->change();
	}
	
}

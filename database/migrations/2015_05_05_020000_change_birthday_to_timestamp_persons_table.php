<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBirthdayToTimestampPersonsTable extends Migration{
	
	public function up(){
		$tableName = DB::getQueryGrammar()->wrapTable('persons');
		
		DB::statement('ALTER TABLE '.$tableName.' CHANGE `birthday` `birthday` TIMESTAMP NULL;');
	}
	
	public function down(){
		$tableName = DB::getQueryGrammar()->wrapTable('persons');
		
		DB::statement('ALTER TABLE '.$tableName.' CHANGE `birthday` `birthday` DATE NULL;');
	}
	
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexesPersonsTable extends Migration{
	
	public function up(){
		Schema::table('persons', function(Blueprint $table){
			$table->index('name');
			$table->index('last_name');
			$table->index('last_name_born');
			$table->index('middle_name');
			$table->index('first_name');
			$table->index('nick_name');
			$table->index('birthday');
			$table->index('deceased_at');
			$table->index('first_met_at');
		});
	}
	
	public function down(){
		Schema::table('persons', function(Blueprint $table){
			$table->dropIndex('persons_name_index');
			$table->dropIndex('persons_last_name_index');
			$table->dropIndex('persons_last_name_born_index');
			$table->dropIndex('persons_middle_name_index');
			$table->dropIndex('persons_first_name_index');
			$table->dropIndex('persons_nick_name_index');
			$table->dropIndex('persons_birthday_index');
			$table->dropIndex('persons_deceased_at_index');
			$table->dropIndex('persons_first_met_at_index');
		});
	}
	
}

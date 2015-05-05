<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBloodTypePersonsTable extends Migration{
	
	public function up(){
		Schema::table('persons', function(Blueprint $table){
			$table->string('blood_type', 2)->nullable()->index();
			$table->string('blood_type_rhd', 1)->nullable()->index();
		});
	}
	
	public function down(){
		Schema::table('persons', function(Blueprint $table){
			$table->dropColumn('blood_type');
			$table->dropColumn('blood_type_rhd');
		});
	}
	
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFacebookIdPersonsTable extends Migration{
	
	public function up(){
		Schema::table('persons', function(Blueprint $table){
			$table->string('facebook_id')->nullable()->index();
		});
	}
	
	public function down(){
		Schema::table('persons', function(Blueprint $table){
			$table->dropColumn('facebook_id');
		});
	}
	
}

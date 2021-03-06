<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Person;

class UpdatePersonsTable20170219 extends Migration{
	
	public function up(){
		Schema::table('persons', function(Blueprint $table){
			$table->string('name', 255)->nullable()->change();
			// $table->string('facebook_url', 768)->nullable()->index();
			$table->text('comment')->nullable()->change();
		});
	}
	
	public function down(){
		Schema::table('persons', function(Blueprint $table){
			$table->string('name', 255)->nullable(false)->change();
			// $table->string('facebook_url', 1024)->nullable(false)->index();
			$table->text('comment')->nullable(false)->change();
		});
	}
	
}

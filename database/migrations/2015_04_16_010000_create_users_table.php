<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration{
	
	public function up(){
		Schema::create('users', function(Blueprint $table){
			$table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->string('name', 255);
			$table->string('email', 255)->unique();
			$table->string('password', 60);
			$table->rememberToken();
			#$table->timestamp('last_login')->nullable()->index();
			$table->timestamps();
			$table->timestamp('deleted_at')->nullable();
		});
	}
	
	public function down(){
		Schema::dropIfExists('users');
	}
	
}

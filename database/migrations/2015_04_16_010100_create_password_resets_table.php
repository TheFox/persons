<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration{
	
	public function up(){
		Schema::create('password_resets', function(Blueprint $table){
			$table->engine = 'InnoDB';
			
			$table->string('email', 255)->index();
			$table->string('token', 64)->index();
			$table->timestamp('created_at');
		});
	}
	
	public function down(){
		Schema::dropIfExists('password_resets');
	}
	
}
